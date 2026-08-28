<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleProposal;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }

    public function allApprovedArticles()
    {
        $articles = Article::where('status', 'approved')->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::where('status', 'approved')->with('comments.user')->findOrFail($id);
        return view('articles.show', compact('article'));
    }

    public function internationalArticles(Request $request)
    {
        $query = Article::whereIn('type', ['national', 'international'])
            ->where('status', 'approved');

        if ($request->filled('keyword')) {
            $query->where('keywords', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('author')) {
            $query->where('authors', 'like', '%' . $request->author . '%');
        }

        if ($request->filled('type_filter')) {
            $query->where('type', $request->type_filter);
        }

        if ($request->filled('year')) {
            $query->where('publication_year', $request->year);
        }

        $articles = $query->orderBy('created_at', 'desc')
            ->paginate(9)
            ->appends($request->only(['keyword', 'author', 'type_filter', 'year']));

        $years = Article::whereIn('type', ['national', 'international'])
            ->where('status', 'approved')
            ->select('publication_year')
            ->distinct()
            ->orderBy('publication_year', 'desc')
            ->pluck('publication_year');

        return view('scientific.articles-international', compact('articles', 'years'));
    }
    public function showInternationalArticle($id)
    {
        $article = Article::whereIn('type', ['national', 'international'])
            ->where('status', 'approved')
            ->findOrFail($id);

        return view('scientific.article-detail', compact('article'));
    }

    public function downloadFile($id)
    {
        $article = Article::findOrFail($id);

        if (!$article->file) {
            abort(404, 'فایل مقاله یافت نشد.');
        }

        $filePath = 'public/articles/files/' . $article->file;
        if (!Storage::exists($filePath)) {
            abort(404, 'فایل مقاله یافت نشد.');
        }

        return Storage::download($filePath);
    }

    public function downloadAbstract($id)
    {
        $article = Article::findOrFail($id);

        if (!$article->abstract_file) {
            abort(404, 'فایل چکیده یافت نشد.');
        }

        $filePath = 'public/articles/abstracts/' . $article->abstract_file;
        if (!Storage::exists($filePath)) {
            abort(404, 'فایل چکیده یافت نشد.');
        }

        return Storage::download($filePath);
    }

    public function viewAbstract($id)
    {
        $article = Article::findOrFail($id);

        if (!$article->abstract_file) {
            abort(404, 'فایل چکیده یافت نشد.');
        }

        $filePath = storage_path('app/public/' . $article->abstract_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'فایل چکیده یافت نشد.');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
    public function approveArticle($id)
    {
        $article = Article::findOrFail($id);
        
        if ($article->status !== 'pending') {
            return back()->with('error', 'این مقاله قبلاً بررسی شده است.');
        }
        
        $oldStatus = $article->status;
        $article->status = 'approved';
        $article->save();
        
        $this->logger->logEntityOperation('approve', 'article', $article->id, true, auth()->id());
        
        return back()->with('success', 'مقاله با موفقیت تایید شد.');
    }

    public function rejectArticle(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);
        
        $article = Article::findOrFail($id);
        
        if ($article->status !== 'pending') {
            return back()->with('error', 'این مقاله قبلاً بررسی شده است.');
        }
        
        $oldStatus = $article->status;
        $article->status = 'rejected';
        $article->admin_note = $validated['admin_note'] ?? null;
        $article->save();
        
        $this->logger->logEntityOperation('reject', 'article', $article->id, true, auth()->id());
        
        return back()->with('success', 'مقاله با موفقیت رد شد.');
    }
    public function manageArticles(Request $request)
    {
        $query = Article::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('content')) {
            $query->where('content', 'like', '%' . $request->content . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $articles = $query->orderBy('id', 'desc')->paginate(10)
            ->appends($request->only(['id', 'type', 'user_name', 'title', 'content', 'status']));

        $proposalQuery = ArticleProposal::query();
        if ($request->filled('proposal_status')) {
            $proposalQuery->where('status', $request->proposal_status);
        }
        if ($request->filled('proposal_title')) {
            $proposalQuery->where('title', 'like', '%' . $request->proposal_title . '%');
        }
        if ($request->filled('proposal_user')) {
            $proposalQuery->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->proposal_user . '%');
            });
        }
        $proposals = $proposalQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'proposals_page')
            ->appends($request->only(['proposal_status', 'proposal_title', 'proposal_user']));

        return view('dashboard.manage-articles', compact('articles', 'proposals'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'in:pending,approved,rejected',
        ]);

        $article = Article::findOrFail($id);
        $article->status = $validated['status'];
        $article->save();

        return back()->with('success', 'وضعیت مقاله به‌روزرسانی شد.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $this->logger->logDataDelete('articles', $article->id, [
            'article_id' => $article->id,
            'title' => $article->title,
            'user_id' => $article->user_id
        ], auth()->id());

        if ($article->file) {
            $filePath = storage_path('app/public/' . $article->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($article->abstract_file) {
            $filePath = storage_path('app/public/' . $article->abstract_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($article->image) {
            $filePath = storage_path('app/public/articles/' . $article->image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $article->delete();

        return back()->with('success', 'مقاله با موفقیت حذف شد.');
    }

    public function myArticles()
    {
        $user = auth()->user();
        $my_articles = $user->articles()->latest()->paginate(10);
        return view('dashboard.my-articles.index', compact('my_articles'));
    }

    public function create()
    {
        return view('dashboard.articles-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:national,international',
            'publication_year' => 'required|string|max:10',
            'status' => 'nullable|in:pending,approved,rejected',
            'file' => 'required|file|mimes:pdf,doc,docx|max:30720',
            'abstract_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
        ], [
            'file.max' => 'حجم فایل اصلی نباید بیشتر از ۳۰ مگابایت باشد.',
            'file.mimes' => 'فرمت فایل اصلی باید PDF، DOC یا DOCX باشد.',
            'abstract_file.max' => 'حجم فایل چکیده نباید بیشتر از ۲۰ مگابایت باشد.',
            'abstract_file.mimes' => 'فرمت فایل چکیده باید PDF، DOC یا DOCX باشد.',
        ]);

        $article = new Article();

        $year = trim($validated['publication_year']);
        $type = $validated['type'];

        if ($type === 'national') {
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $year = str_replace($persian, $english, $year);

            if (!preg_match('/^\d{4}$/', $year)) {
                return back()->withErrors(['publication_year' => 'سال انتشار برای مقالات بومی باید به صورت شمسی (۴ رقمی) وارد شود.'])
                    ->withInput();
            }

            $yearNum = (int)$year;
            if ($yearNum < 1380 || $yearNum > 1405) {
                return back()->withErrors(['publication_year' => 'سال انتشار باید بین ۱۳۸۰ تا ۱۴۰۵ باشد.'])
                    ->withInput();
            }

        } elseif ($type === 'international') {
            if (!preg_match('/^\d{4}$/', $year)) {
                return back()->withErrors(['publication_year' => 'سال انتشار برای مقالات بین‌المللی باید به صورت میلادی (۴ رقمی انگلیسی) وارد شود.'])
                    ->withInput();
            }

            $yearNum = (int)$year;
            if ($yearNum < 1990 || $yearNum > 2026) {
                return back()->withErrors(['publication_year' => 'سال انتشار باید بین ۱۹۹۰ تا ۲۰۲۶ باشد.'])
                    ->withInput();
            }
        }

        $article->title = $validated['title'];
        $article->authors = $validated['authors'];
        $article->keywords = $validated['keywords'] ?? null;
        $article->description = $validated['description'] ?? null;
        $article->type = $validated['type'];
        $article->publication_year = $year;
        $article->status = $validated['status'] ?? 'pending';
        $article->user_id = auth()->id();
        $article->content = ' ';
        $article->is_published = true;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/articles/files', $filename);
            $article->file = 'articles/files/' . $filename;
        } else {
            return back()->with('error', 'فایل اصلی مقاله معتبر نیست یا آپلود نشده است.');
        }

        if ($request->hasFile('abstract_file') && $request->file('abstract_file')->isValid()) {
            $file = $request->file('abstract_file');
            $filename = uniqid() . '_abstract_' . $file->getClientOriginalName();
            $file->storeAs('public/articles/abstracts', $filename);
            $article->abstract_file = 'articles/abstracts/' . $filename;
        }

        $article->save();

        $this->logger->logDataCreate('articles', $article->id, [
            'article_id' => $article->id,
            'title' => $article->title,
            'type' => $article->type,
            'status' => $article->status,
            'user_id' => auth()->id()
        ], auth()->id());

        return redirect()->route('dashboard.manage-articles.index')
            ->with('success', 'مقاله با موفقیت ثبت شد.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() === $article->user_id) {
            return view('dashboard.my-articles.edit', compact('article'));
        }

        return abort(403);
    }

    public function editArticle($id)
    {
        $article = Article::findOrFail($id);
        return view('dashboard.articles-edit', compact('article'));
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:national,international',
            'publication_year' => 'required|string|max:10',
            'status' => 'nullable|in:pending,approved,rejected',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:51200',
            'abstract_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'nullable|boolean',
        ]);

    if ($request->hasFile('file') && $request->file('file')->isValid() && $request->missing('remove_file')) {
        if ($article->file) {
            Storage::disk('public')->delete($article->file);
        }
        $file = $request->file('file');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/articles/files', $filename);
        $article->file = 'articles/files/' . $filename;
    }

    if ($request->hasFile('abstract_file') && $request->file('abstract_file')->isValid() && $request->missing('remove_abstract')) {
        if ($article->abstract_file) {
            Storage::disk('public')->delete($article->abstract_file);
        }
        $file = $request->file('abstract_file');
        $filename = uniqid() . '_abstract_' . $file->getClientOriginalExtension();
        $file->storeAs('public/articles/abstracts', $filename);
        $article->abstract_file = 'articles/abstracts/' . $filename;
    }

        if ($request->has('is_free') && $request->is_free == 1) {
            $article->is_free = true;
            $article->price = null;
        } else {
            $price = (int)$request->price ?? 0;
            if ($price < 10000) {
                return back()->withErrors(['price' => 'قیمت مقاله باید حداقل ۱۰,۰۰۰ تومان باشد.'])
                    ->withInput();
            }
            $article->is_free = false;
            $article->price = $price;
            $article->price_set_by = auth()->id();
        }
        $year = trim($validated['publication_year']);
        $type = $validated['type'];

        if ($type === 'national') {
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $year = str_replace($persian, $english, $year);

            if (!preg_match('/^\d{4}$/', $year)) {
                return back()->withErrors(['publication_year' => 'سال انتشار باید ۴ رقمی باشد.'])->withInput();
            }
            $yearNum = (int)$year;
            if ($yearNum < 1380 || $yearNum > 1405) {
                return back()->withErrors(['publication_year' => 'سال انتشار باید بین ۱۳۸۰ تا ۱۴۰۵ باشد.'])->withInput();
            }

        } elseif ($type === 'international') {
            if (!preg_match('/^\d{4}$/', $year)) {
                return back()->withErrors(['publication_year' => 'سال انتشار باید ۴ رقمی باشد.'])->withInput();
            }
            $yearNum = (int)$year;
            if ($yearNum < 1990 || $yearNum > 2026) {
                return back()->withErrors(['publication_year' => 'سال انتشار باید بین ۱۹۹۰ تا ۲۰۲۶ باشد.'])->withInput();
            }
        }

        $article->title = $validated['title'];
        $article->authors = $validated['authors'];
        $article->keywords = $validated['keywords'] ?? null;
        $article->description = $validated['description'] ?? null;
        $article->type = $validated['type'];
        $article->publication_year = $year;
        $article->status = $validated['status'] ?? $article->status;
        
        if ($request->has('is_free') && $request->is_free == 1) {
            $article->is_free = true;
            $article->price = null;
        } else {
            $article->is_free = false;
            $article->price = $request->price ?? 0;
            $article->price_set_by = auth()->id();
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            if ($article->file) {
                Storage::delete('public/' . $article->file);
            }
            $file = $request->file('file');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/articles/files', $filename);
            $article->file = 'articles/files/' . $filename;
        }

        if ($request->hasFile('abstract_file') && $request->file('abstract_file')->isValid()) {
            if ($article->abstract_file) {
                Storage::delete('public/' . $article->abstract_file);
            }
            $file = $request->file('abstract_file');
            $filename = uniqid() . '_abstract_' . $file->getClientOriginalName();
            $file->storeAs('public/articles/abstracts', $filename);
            $article->abstract_file = 'articles/abstracts/' . $filename;
        }

        $this->logger->logDataUpdate('articles', $article->id, [
            'old_title' => $article->getOriginal('title'),
            'old_status' => $article->getOriginal('status'),
            'old_type' => $article->getOriginal('type')
        ], [
            'new_title' => $article->title,
            'new_status' => $article->status,
            'new_type' => $article->type
        ], auth()->id());
        
        $article->save();

        return redirect()->route('dashboard.manage-articles.index')
            ->with('success', 'مقاله با موفقیت به‌روزرسانی شد.');
    }
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:500',
            'remove_image' => 'sometimes|boolean',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'remove_file' => 'sometimes|boolean',
            'keywords' => 'nullable|string|max:500',
            'authors' => 'nullable|string|max:500',
            'type' => 'nullable|in:national,international,local',
            'publication_year' => 'nullable|string|max:10',
            'abstract_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'remove_abstract' => 'sometimes|boolean',
        ], [
            'file.max' => 'حجم فایل اصلی نباید بیشتر از ۳۰ مگابایت باشد.',
            'file.mimes' => 'فرمت فایل اصلی باید PDF، DOC یا DOCX باشد.',
            'abstract_file.max' => 'حجم فایل چکیده نباید بیشتر از ۲۰ مگابایت باشد.',
            'abstract_file.mimes' => 'فرمت فایل چکیده باید PDF، DOC یا DOCX باشد.',
        ]);

        $article->title = $validated['title'];
        $article->content = $validated['content'];

        if ($request->filled('keywords')) {
            $article->keywords = $validated['keywords'];
        }
        if ($request->filled('authors')) {
            $article->authors = $validated['authors'];
        }
        if ($request->filled('type')) {
            $article->type = $validated['type'];
        }
        if ($request->filled('publication_year')) {
            $article->publication_year = $validated['publication_year'];
        }

        if ($request->has('remove_image') && $article->image) {
            Storage::delete('public/articles/' . $article->image);
            $article->image = null;
        }

        if ($request->hasFile('image') && $request->missing('remove_image')) {
            if ($article->image) {
                Storage::delete('public/articles/' . $article->image);
            }
            $image = $validated['image'];
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/articles', $filename);
            $article->image = $filename;
        }

        if ($request->has('remove_file') && $article->file) {
            Storage::delete('public/articles/files/' . $article->file);
            $article->file = null;
        }

        if ($request->hasFile('file') && $request->missing('remove_file')) {
            if ($article->file) {
                Storage::delete('public/articles/files/' . $article->file);
            }
            $file = $validated['file'];
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/articles/files', $filename);
            $article->file = $filename;
        }

        if ($request->has('remove_abstract') && $article->abstract_file) {
            Storage::delete('public/articles/abstracts/' . $article->abstract_file);
            $article->abstract_file = null;
        }

        if ($request->hasFile('abstract_file') && $request->missing('remove_abstract')) {
            if ($article->abstract_file) {
                Storage::delete('public/articles/abstracts/' . $article->abstract_file);
            }
            $file = $validated['abstract_file'];
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/articles/abstracts', $filename);
            $article->abstract_file = $filename;
        }

        $oldData = [
            'title' => $article->getOriginal('title'),
            'content' => $article->getOriginal('content'),
            'keywords' => $article->getOriginal('keywords'),
            'authors' => $article->getOriginal('authors'),
            'type' => $article->getOriginal('type'),
            'publication_year' => $article->getOriginal('publication_year')
        ];
        
        $newData = [
            'title' => $article->title,
            'content' => $article->content,
            'keywords' => $article->keywords,
            'authors' => $article->authors,
            'type' => $article->type,
            'publication_year' => $article->publication_year
        ];
        
        $article->status = 'pending';
        $article->save();

        $this->logger->logDataUpdate('articles', $article->id, $oldData, $newData, auth()->id());

        return redirect()->route('dashboard.my-articles.index')
            ->with('success', 'مقاله با موفقیت ویرایش شد و پس از بررسی و تایید ادمین، منتشر خواهد شد.');
    }

    public function destroyOwnArticle($id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() === $article->user_id) {
            if ($article->file) {
                $filePath = storage_path('app/public/' . $article->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            if ($article->abstract_file) {
                $filePath = storage_path('app/public/' . $article->abstract_file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            if ($article->image) {
                $filePath = storage_path('app/public/articles/' . $article->image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $this->logger->logDataDelete('articles', $article->id, [
                'article_id' => $article->id,
                'title' => $article->title,
                'deleted_by_owner' => true
            ], auth()->id());
            
            $article->delete();
            return back()->with('success', 'مقاله با موفقیت حذف شد.');
        }

        return abort(403);
    }

    public function generateFakeArticle()
    {
        $article = \App\Models\Article::factory()->create();
        return response()->json($article);
    }
}