<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function generateFakeNews()
    {
        $news = \App\Models\News::factory()->create();
        return response()->json($news);
    }

    public function allApprovedNews(){
        $news = News::where('status', 'approved')->where('is_archived', 0)->latest()->paginate(12);
        return view('news.index', compact('news'));
    }

    public function show($id)
    {
        $news = News::where('status', 'approved')->where('is_archived', 0)->with('comments.user')->findOrFail($id);
        return view('news.show', compact('news'));
    }

    public function manageNews(Request $request)
    {
        $query = News::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('user_name')) {
            $query->whereHas('user', function($q) use ($request){
                $q->where('name', 'like', '%'.$request->user_name.'%');
            });
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%'.$request->title.'%');
        }
        if ($request->filled('content')) {
            $query->where('content', 'like', '%'.$request->content.'%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('archive_status')) {
            if ($request->input('archive_status') === 'current') {
                $query->where('is_archived', 0);
            }
            if ($request->input('archive_status') === 'archived') {
                $query->where('is_archived', 1);
            }
        }

        $news = $query->orderBy('created_at','desc')->paginate(20)
                      ->appends($request->only(['id','user_name','title','content','status','archive_status']));

        return view('dashboard.manage-news.index', compact('news'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'in:pending,approved,rejected',
        ]);

        $news = News::findOrFail($id);
        $oldStatus = $news->status;
        $news->status = $validated['status'];
        $news->save();

        $this->logger->logEntityOperation('update_status', 'news', $news->id, true, auth()->id());

        return back()->with('success', 'وضعیت خبر به‌روزرسانی شد.');
    }

    public function updateIsArchived(Request $request, $id)
    {
        $validated = $request->validate([
            'is_archived' => 'sometimes|boolean',
        ]);

        $news = News::findOrFail($id);
        $news->is_archived = $request->has('is_archived');
        $news->save();

        return back()->with('success', 'وضعیت خبر به‌روزرسانی شد.');
    }

    public function create()
    {
        return view('dashboard.submit-news');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'image' => 'nullable|image|max:500',
            'slider_images' => 'nullable|array|max:10',
            'slider_images.*' => 'image|max:500'
        ]);

        $news = new News();
        $news->title = $validated['title'];
        $news->content = $validated['content'];
        $news->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $image = $validated['image'];
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/news', $filename);
            $news->image = $filename;
        }

        if ($request->hasFile('slider_images')) {
            $newSliderImages = [];
            foreach ($validated['slider_images'] as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/news', $filename);
                $newSliderImages[] = $filename;
            }
            $news->slider_images = $newSliderImages;
        }

        $news->save();
        return redirect()->route('dashboard.index')->with('success', 'خبر با موفقیت ثبت شد و پس از بررسی و تایید ادمین، منتشر خواهد شد.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('dashboard.manage-news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'image' => 'nullable|image|max:500',
            'remove_image' => 'sometimes|boolean',
            'slider_images' => 'nullable|array|max:10',
            'remove_slider' => 'sometimes|boolean',
            'slider_images.*' => 'image|max:500'
        ]);

        $news->title = $validated['title'];
        $news->content = $validated['content'];

        if ($request->has('remove_image') && $news->image)
        {
            Storage::delete('public/news/' . $news->image);
            $news->image = null;
        }

        if ($request->hasFile('image') && $request->missing('remove_image'))
        {
            if ($news->image) {
                Storage::delete('public/news/' . $news->image);
            }
            $image = $validated['image'];
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/news', $filename);
            $news->image = $filename;
        }

        if ($request->has('remove_slider') && $news->slider_images)
        {
            foreach ($news->slider_images as $image) {
                Storage::delete('public/news/' . $image);
            }
            $news->slider_images = null;
        }

        if ($request->hasFile('slider_images') && $request->missing('remove_slider'))
        {
            if ($news->slider_images) {
                foreach ($news->slider_images as $image) {
                    Storage::delete('public/news/' . $image);
                }
            }

            $newSliderImages = [];
            foreach ($validated['slider_images'] as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/news', $filename);
                $newSliderImages[] = $filename;
            }
            $news->slider_images = $newSliderImages;
        }

        $news->save();
        return redirect()->route('dashboard.manage-news.index')->with('success', 'خبر با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        $this->logger->logDataDelete('news', $news->id, [
            'news_id' => $news->id,
            'title' => $news->title,
            'user_id' => $news->user_id
        ], auth()->id());

        if ($news->image) {
            Storage::delete('public/news/' . $news->image);
        }

        if ($news->slider_images) {
            foreach ($news->slider_images as $image) {
                Storage::delete('public/news/' . $image);
            }
        }

        $news->delete();
        return back()->with('success', 'خبر حذف شد.');
    }

}
