<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\LoggingService;

class CommentController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function generateFakeComment()
    {
        $comment = \App\Models\Comment::factory()->create();
        return response()->json($comment);
    }

    public function storeForNews(Request $request, $id)
    {
        $validated = $request->validate(['content' => 'required|string|max:500']);

        Comment::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'news_id' => $id,
        ]);

        return back()->with('success', 'نظر شما ثبت شد و پس از بررسی و تایید، نمایش داده می‌شود.');
    }

    public function storeForArticle(Request $request, $id)
    {
        $validated = $request->validate(['content' => 'required|string|max:500']);

        Comment::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'article_id' => $id,
        ]);

        return back()->with('success', 'نظر شما ثبت شد و پس از بررسی و تایید، نمایش داده می‌شود.');
    }

    public function manageComments(Request $request)
    {
        $query = Comment::query();

        if ($request->filled('user_name')) {
            $query->whereHas('user', function($q) use ($request){
                $q->where('name', 'like', '%'.$request->user_name.'%');
            });
        }
        if ($request->filled('news_id')) {
            $query->where('news_id', $request->news_id);
        }
        if ($request->filled('article_id')) {
            $query->where('article_id', $request->article_id);
        }
        if ($request->filled('content')) {
            $query->where('content', 'like', '%'.$request->content.'%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $comments = $query->orderBy('created_at','desc')->paginate(25)
                          ->appends($request->only(['user_name','news_id','article_id','content','status']));

        return view('dashboard.manage-comments', compact('comments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'in:pending,approved,rejected',
        ]);

        $comment = Comment::findOrFail($id);
        $oldStatus = $comment->status;
        $comment->status = $validated['status'];
        $comment->save();

        $this->logger->logEntityOperation('update_status', 'comment', $comment->id, true, auth()->id());

        return back()->with('success', 'وضعیت کامنت به‌روزرسانی شد.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $this->logger->logDataDelete('comments', $comment->id, [
            'comment_id' => $comment->id,
            'user_id' => $comment->user_id,
            'content_preview' => mb_substr($comment->content, 0, 50)
        ], auth()->id());

        $comment->delete();
        return back()->with('success', 'کامنت حذف شد.');
    }

}
