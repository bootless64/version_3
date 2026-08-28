<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserDownload;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function addToCart(Request $request, $articleId)
    {
        $article = Article::where('status', 'approved')
            ->where('is_published', true)
            ->findOrFail($articleId);

        if ($article->is_free) {
            return response()->json([
                'success' => false,
                'message' => 'این مقاله رایگان است و نیازی به خرید ندارد.'
            ], 400);
        }

        if ($article->isPurchasedByUser(Auth::id())) {
            return response()->json([
                'success' => false,
                'message' => 'شما قبلاً این مقاله را خریداری کرده‌اید.'
            ], 400);
        }

        $existingOrder = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereHas('items', function ($q) use ($articleId) {
                $q->where('article_id', $articleId);
            })
            ->exists();

        if ($existingOrder) {
            return response()->json([
                'success' => false,
                'message' => 'این مقاله قبلاً به سبد خرید شما اضافه شده است.'
            ], 400);
        }

        $order = Order::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status' => 'pending',
            ],
            [
                'buyer_name' => Auth::user()->name,
                'buyer_email' => Auth::user()->email,
                'buyer_phone' => Auth::user()->mobile_number ?? '',
                'total_amount' => 0,
                'terms_accepted' => false,
            ]
        );

        OrderItem::create([
            'order_id' => $order->id,
            'article_id' => $article->id,
            'price' => $article->price,
        ]);

        $order->total_amount = $order->items()->sum('price');
        $order->save();

        $this->logger->logDataCreate('cart_items', null, [
            'order_id' => $order->id,
            'article_id' => $article->id,
            'article_title' => $article->title,
            'price' => $article->price,
            'user_id' => auth()->id()
        ], auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'مقاله به سبد خرید اضافه شد.'
        ]);
    }

    public function cart()
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with('items.article')
            ->first();

        return view('shop.cart', compact('order'));
    }
    public function removeFromCartByArticle($articleId)
    {
        try {
            $order = Order::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'سبد خرید شما خالی است.'
                ]);
            }

            $item = OrderItem::where('order_id', $order->id)
                ->where('article_id', $articleId)
                ->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'این مقاله در سبد خرید شما وجود ندارد.'
                ]);
            }

            $item->delete();

            $order->total_amount = $order->items()->sum('price');
            $order->save();

            if ($order->items()->count() == 0) {
                $order->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'مقاله از سبد خرید حذف شد.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف مقاله: ' . $e->getMessage()
            ]);
        }
    }
    public function removeFromCart($itemId)
    {
        $item = OrderItem::findOrFail($itemId);
        $order = $item->order;

        if ($order->user_id != Auth::id() || $order->status != 'pending') {
            abort(403);
        }

        $item->delete();

        $order->total_amount = $order->items()->sum('price');
        $order->save();

        if ($order->items()->count() == 0) {
            $order->delete();
            return redirect()->route('shop.cart')
                ->with('info', 'سبد خرید شما خالی شد.');
        }

        return back()->with('success', 'آیتم از سبد خرید حذف شد.');
    }

    public function checkout()
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with('items.article')
            ->firstOrFail();

        return view('shop.checkout', compact('order'));
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email|max:255',
            'buyer_phone' => 'required|string|max:20',
            'terms_accepted' => 'required|accepted',
        ]);

        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with('items.article')
            ->firstOrFail();

        $order->update([
            'buyer_name' => $validated['buyer_name'],
            'buyer_email' => $validated['buyer_email'],
            'buyer_phone' => $validated['buyer_phone'],
            'terms_accepted' => true,
        ]);

        $paymentSuccess = false;

        $this->logger->logEntityOperation('payment_attempt', 'order', $order->id, $paymentSuccess, auth()->id());

        if ($paymentSuccess) {
            DB::transaction(function () use ($order) {
                $order->update([
                    'status' => 'paid',
                    'transaction_id' => 'SIM_' . uniqid(),
                    'paid_at' => now(),
                    'payment_method' => 'simulated',
                ]);

                foreach ($order->items as $item) {
                    UserDownload::create([
                        'user_id' => $order->user_id,
                        'article_id' => $item->article_id,
                        'order_id' => $order->id,
                        'downloaded_at' => null,
                    ]);
                }

                $this->logger->logDataUpdate('orders', $order->id, [
                    'old_status' => 'pending'
                ], [
                    'new_status' => 'paid',
                    'transaction_id' => $order->transaction_id,
                    'total_amount' => $order->total_amount
                ], auth()->id());
            });

            return redirect()->route('shop.payment-success', $order->id)
                ->with('success', 'پرداخت با موفقیت انجام شد.');
        }

        return redirect()->route('shop.payment-failed', $order->id)
            ->with('error', 'پرداخت ناموفق بود. لطفاً مجدداً تلاش کنید.');
    }

    public function paymentSuccess($orderId)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->with('items.article')
            ->findOrFail($orderId);

        return view('shop.payment-success', compact('order'));
    }

    public function paymentFailed($orderId)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($orderId);

        return view('shop.payment-failed', compact('order'));
    }

    public function downloadPurchasedArticle($articleId)
    {
        $article = Article::findOrFail($articleId);

        if ($article->is_free) {
            return $this->downloadFile($article);
        }

        $hasAccess = UserDownload::where('user_id', Auth::id())
            ->where('article_id', $articleId)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'شما دسترسی به دانلود این مقاله را ندارید.');
        }

        UserDownload::where('user_id', Auth::id())
            ->where('article_id', $articleId)
            ->update(['downloaded_at' => now()]);

        return $this->downloadFile($article);
    }

    private function downloadFile($article)
    {
        if (!$article->file) {
            abort(404, 'فایل مقاله یافت نشد.');
        }

        $filePath = storage_path('app/public/' . $article->file);
        if (!file_exists($filePath)) {
            abort(404, 'فایل مقاله یافت نشد.');
        }

        return response()->download($filePath);
    }

    public function manageOrders(Request $request)
    {
        $query = Order::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('buyer_name')) {
            $query->where('buyer_name', 'like', '%' . $request->buyer_name . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->with('user', 'items.article')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->only(['id', 'buyer_name', 'status', 'date_from', 'date_to']));

        return view('dashboard.manage-orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('user', 'items.article', 'downloads')
            ->findOrFail($id);

        return view('dashboard.order-details', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,failed,expired',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $validated['status'];
        $order->admin_note = $validated['admin_note'] ?? $order->admin_note;
        $order->save();

        return back()->with('success', 'وضعیت سفارش با موفقیت به‌روزرسانی شد.');
    }
    public function orderDetails($id)
    {
        $query = Order::with('items.article');

        if (!auth()->user()->can('manage_orders')) {
            $query->where('user_id', auth()->id());
        }

        $order = $query->findOrFail($id);

        return view('dashboard.order-details', compact('order'));
    }
    public function destroyOrder($id)
    {
        $order = Order::findOrFail($id);

        $order->items()->delete();
        $order->downloads()->delete();
        $order->delete();

        return back()->with('success', 'سفارش با موفقیت حذف شد.');
    }
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->with('items.article')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.my-orders', compact('orders'));
    }
}