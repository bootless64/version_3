<?php

namespace App\Http\Controllers;

use App\Models\ArticleProposal;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Storage;

class ArticleProposalController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function index()
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'برای ارسال پیشنهاد مقاله باید وارد سیستم شوید.');
        }

        $user = auth()->user();
        $proposals = ArticleProposal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('scientific.submit-proposal', compact('proposals'));
    }

    public function store(Request $request)
    {
        $submissionType = $request->input('submission_type', 'article');

        $proposal = new ArticleProposal();
        $proposal->user_id = auth()->id();
        $proposal->status = 'pending';
        $proposal->submission_type = $submissionType;

        if ($submissionType === 'article') {
            $validated = $request->validate([
                'submission_type' => 'required|in:article,thesis,proposal_article,proposal_thesis',
                'title' => 'required|string|max:255',
                'authors' => 'required|string|max:500',
                'keywords' => 'nullable|string|max:500',
                'description' => 'nullable|string|max:500',
                'type' => 'required|in:national,international',
                'publication_year' => 'required|string|max:10',
                'file' => 'required|file|mimes:pdf,doc,docx|max:30720',
                'abstract_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            ], [
                'file.max' => 'حجم فایل اصلی نباید بیشتر از ۳۰ مگابایت باشد.',
                'file.mimes' => 'فرمت فایل اصلی باید PDF، DOC یا DOCX باشد.',
                'abstract_file.max' => 'حجم فایل چکیده نباید بیشتر از ۲۰ مگابایت باشد.',
                'abstract_file.mimes' => 'فرمت فایل چکیده باید PDF، DOC یا DOCX باشد.',
            ]);

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

            $proposal->title = $validated['title'];
            $proposal->authors = $validated['authors'];
            $proposal->keywords = $validated['keywords'] ?? null;
            $proposal->description = $validated['description'] ?? null;
            $proposal->type = $validated['type'];
            $proposal->publication_year = $year;

            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/proposals/article/files', $filename);
                $proposal->file = 'proposals/article/files/' . $filename;
            } else {
                return back()->with('error', 'فایل اصلی مقاله معتبر نیست یا آپلود نشده است.');
            }

            if ($request->hasFile('abstract_file') && $request->file('abstract_file')->isValid()) {
                $file = $request->file('abstract_file');
                $filename = uniqid() . '_abstract_' . $file->getClientOriginalName();
                $file->storeAs('public/proposals/article/abstracts', $filename);
                $proposal->abstract_file = 'proposals/article/abstracts/' . $filename;
            }

            $proposal->save();

            $this->logger->logDataCreate('article_proposals', $proposal->id, [
                'type' => 'article',
                'title' => $proposal->title,
                'submission_type' => $proposal->submission_type,
            ], auth()->id());

            return redirect()->route('submit-proposal.index')
                ->with('success', 'مقاله شما با موفقیت ثبت شد و در انتظار تایید مدیر می‌باشد.');
        }

        if ($submissionType === 'thesis') {
            $validated = $request->validate([
                'submission_type' => 'required|in:article,thesis,proposal_article,proposal_thesis',
                'thesis_type' => 'required|in:thesis,dissertation',
                'title' => 'required|string|max:255',
                'student_name' => 'required|string|max:255',
                'supervisor' => 'nullable|string|max:255',
                'research_field' => 'required|string|max:255',
                'keywords' => 'nullable|string|max:500',
                'defense_year' => 'required|string|max:10',
                'description' => 'nullable|string|max:500',
                'file' => 'required|file|mimes:pdf,doc,docx|max:30720',
                'abstract_file' => 'required|file|mimes:pdf,doc,docx|max:20480',
            ], [
                'file.max' => 'حجم فایل پایان‌نامه/رساله نباید بیشتر از ۳۰ مگابایت باشد.',
                'file.mimes' => 'فرمت فایل پایان‌نامه/رساله باید PDF، DOC یا DOCX باشد.',
                'abstract_file.max' => 'حجم فایل چکیده نباید بیشتر از ۲۰ مگابایت باشد.',
                'abstract_file.mimes' => 'فرمت فایل چکیده باید PDF، DOC یا DOCX باشد.',
            ]);

            $year = trim($validated['defense_year']);
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $year = str_replace($persian, $english, $year);
            if (!preg_match('/^\d{4}$/', $year)) {
                return back()->withErrors(['defense_year' => 'سال دفاع باید به صورت ۴ رقمی وارد شود.'])->withInput();
            }

            $proposal->title = $validated['title'];
            $proposal->student_name = $validated['student_name'];
            $proposal->supervisor = $validated['supervisor'] ?? null;
            $proposal->research_field = $validated['research_field'];
            $proposal->keywords = $validated['keywords'] ?? null;
            $proposal->description = $validated['description'] ?? null;
            $proposal->defense_year = $year;
            $proposal->thesis_type = $validated['thesis_type'];

            $proposal->authors = $validated['student_name'];
            $proposal->type = 'national';
            $proposal->publication_year = $year;

            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/proposals/thesis/files', $filename);
                $proposal->file = 'proposals/thesis/files/' . $filename;
            } else {
                return back()->with('error', 'فایل پایان‌نامه/رساله معتبر نیست یا آپلود نشده است.');
            }

            if ($request->hasFile('abstract_file') && $request->file('abstract_file')->isValid()) {
                $file = $request->file('abstract_file');
                $filename = uniqid() . '_abstract_' . $file->getClientOriginalName();
                $file->storeAs('public/proposals/thesis/abstracts', $filename);
                $proposal->abstract_file = 'proposals/thesis/abstracts/' . $filename;
            } else {
                return back()->with('error', 'فایل چکیده معتبر نیست یا آپلود نشده است.');
            }

            $proposal->save();

            return redirect()->route('submit-proposal.index')
                ->with('success', 'پایان‌نامه/رساله شما با موفقیت ثبت شد و در انتظار بررسی می‌باشد.');
        }

        if ($submissionType === 'proposal_article') {
            $validated = $request->validate([
                'submission_type' => 'required|in:article,thesis,proposal_article,proposal_thesis',
                'title' => 'required|string|max:255',
                'title_explanation' => 'required|string|max:1000',
                'keywords' => 'nullable|string|max:500',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
                'similar_status' => 'required|in:exists,does_not_exist,no_info',
                'similar_year' => 'nullable|string|max:20',
                'similar_place' => 'nullable|string|max:255',
                'similar_link' => 'nullable|url|max:500',
            ], [
                'file.max' => 'حجم فایل نباید بیشتر از ۳۰ مگابایت باشد.',
                'file.mimes' => 'فرمت فایل باید PDF، DOC یا DOCX باشد.',
            ]);

            $normalizedSimilarStatus = ($validated['similar_status'] === 'exists') ? 'exists' : 'not_exists';

            $proposal->title = $validated['title'];
            $proposal->title_explanation = $validated['title_explanation'];
            $proposal->keywords = $validated['keywords'] ?? null;
            $proposal->description = null;
            $proposal->similar_status = $normalizedSimilarStatus;
            $proposal->similar_year = ($normalizedSimilarStatus === 'exists') ? ($validated['similar_year'] ?? null) : null;
            $proposal->similar_place = ($normalizedSimilarStatus === 'exists') ? ($validated['similar_place'] ?? null) : null;
            $proposal->similar_link = ($normalizedSimilarStatus === 'exists') ? ($validated['similar_link'] ?? null) : null;

            $proposal->authors = auth()->user()->name ?? '—';
            $proposal->type = 'national';
            $proposal->publication_year = '';

            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/proposals/proposal_article/files', $filename);
                $proposal->file = 'proposals/proposal_article/files/' . $filename;
            }

            $proposal->save();

            return redirect()->route('submit-proposal.index')
                ->with('success', 'پیشنهاد مقاله شما با موفقیت ثبت شد و در انتظار بررسی می‌باشد.');
        }

        if ($submissionType === 'proposal_thesis') {
            $validated = $request->validate([
                'submission_type' => 'required|in:article,thesis,proposal_article,proposal_thesis',
                'thesis_type' => 'required|in:thesis,dissertation',
                'title' => 'required|string|max:255',
                'title_explanation' => 'required|string|max:1000',
                'keywords' => 'nullable|string|max:500',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
                'similar_status' => 'required|in:exists,does_not_exist,no_info',
                'similar_year' => 'nullable|string|max:20',
                'similar_place' => 'nullable|string|max:255',
                'similar_link' => 'nullable|url|max:500',
            ], [
                'file.max' => 'حجم فایل نباید بیشتر از ۳۰ مگابایت باشد.',
                'file.mimes' => 'فرمت فایل باید PDF، DOC یا DOCX باشد.',
            ]);

            $normalizedSimilarStatus = ($validated['similar_status'] === 'exists') ? 'exists' : 'not_exists';

            $proposal->title = $validated['title'];
            $proposal->thesis_type = $validated['thesis_type'];
            $proposal->title_explanation = $validated['title_explanation'];
            $proposal->keywords = $validated['keywords'] ?? null;
            $proposal->similar_status = $normalizedSimilarStatus;
            $proposal->similar_year = ($normalizedSimilarStatus === 'exists') ? ($validated['similar_year'] ?? null) : null;
            $proposal->similar_place = ($normalizedSimilarStatus === 'exists') ? ($validated['similar_place'] ?? null) : null;
            $proposal->similar_link = ($normalizedSimilarStatus === 'exists') ? ($validated['similar_link'] ?? null) : null;

            $proposal->authors = auth()->user()->name ?? '—';
            $proposal->type = 'national';
            $proposal->publication_year = '';

            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/proposals/proposal_thesis/files', $filename);
                $proposal->file = 'proposals/proposal_thesis/files/' . $filename;
            }

            $proposal->save();

            return redirect()->route('submit-proposal.index')
                ->with('success', 'پیشنهاد پایان‌نامه/رساله شما با موفقیت ثبت شد و در انتظار بررسی می‌باشد.');
        }

        return back()->with('error', 'نوع ارسال معتبر نیست.');
    }

    public function destroy($id)
    {
        $proposal = ArticleProposal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        if ($proposal->file) {
            Storage::delete('public/' . $proposal->file);
        }
        if ($proposal->abstract_file) {
            Storage::delete('public/' . $proposal->abstract_file);
        }

        $proposal->delete();

        return back()->with('success', 'پیشنهاد با موفقیت حذف شد.');
    }

    public function manageProposals(Request $request)
    {
        $query = ArticleProposal::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        $proposals = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('scientific.manage-proposals', compact('proposals'));
    }

    public function approveProposal($id)
    {
        $proposal = ArticleProposal::findOrFail($id);

        if ($proposal->status !== 'pending') {
            return back()->with('error', 'این پیشنهاد قبلاً بررسی شده است.');
        }

        $submissionType = $proposal->submission_type ?? 'article';

        $article = new \App\Models\Article();
        $article->user_id     = $proposal->user_id;
        $article->content     = ' ';
        $article->status      = 'approved';
        $article->is_published = true;
        $article->is_free     = true;
        $article->keywords    = $proposal->keywords;
        $article->description = $proposal->description ?? $proposal->title_explanation;

        switch ($submissionType) {

            case 'article':
                $article->title            = $proposal->title;
                $article->authors          = $proposal->authors;
                $article->type             = $proposal->type;
                $article->publication_year = $proposal->publication_year;
                break;

            case 'thesis':
                $article->title            = $proposal->title;
                $article->authors          = $proposal->student_name
                    . ($proposal->supervisor ? ' — استاد راهنما: ' . $proposal->supervisor : '');
                $article->type             = 'national';
                $article->publication_year = $proposal->defense_year ?? $proposal->publication_year;
                break;

            case 'proposal_article':
                $article->title            = $proposal->title;
                $article->authors          = $proposal->authors ?? auth()->user()->name;
                $article->type             = $proposal->type ?? 'national';
                $article->publication_year = $proposal->publication_year ?? '';
                $article->description      = $proposal->title_explanation ?? $proposal->description;
                break;

            case 'proposal_thesis':
                $article->title            = $proposal->title;
                $article->authors          = $proposal->authors ?? auth()->user()->name;
                $article->type             = 'national';
                $article->publication_year = $proposal->publication_year ?? '';
                $article->description      = $proposal->title_explanation ?? $proposal->description;
                break;

            default:
                return back()->with('error', 'نوع پیشنهاد نامعتبر است.');
        }

        if ($proposal->file) {
            $oldPath = storage_path('app/public/' . $proposal->file);
            if (file_exists($oldPath)) {
                $newFilename = uniqid() . '_' . basename($proposal->file);
                $newPath     = 'articles/files/' . $newFilename;
                copy($oldPath, storage_path('app/public/' . $newPath));
                $article->file = $newPath;
            }
        }

        if ($proposal->abstract_file) {
            $oldPath = storage_path('app/public/' . $proposal->abstract_file);
            if (file_exists($oldPath)) {
                $newFilename = uniqid() . '_abstract_' . basename($proposal->abstract_file);
                $newPath     = 'articles/abstracts/' . $newFilename;
                copy($oldPath, storage_path('app/public/' . $newPath));
                $article->abstract_file = $newPath;
            }
        }

        $article->save();

        $proposal->status = 'approved';
        $proposal->save();

        $this->logger->logEntityOperation('approve_proposal', 'article_proposal', $proposal->id, true, auth()->id());

        return back()->with('success', 'پیشنهاد با موفقیت تایید و به مقالات اضافه شد.');
    }

    public function rejectProposal(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $proposal = ArticleProposal::findOrFail($id);

        if ($proposal->status !== 'pending') {
            return back()->with('error', 'این پیشنهاد قبلاً بررسی شده است.');
        }

        $proposal->status = 'rejected';
        $proposal->admin_note = $validated['admin_note'] ?? null;
        $proposal->save();

        $this->logger->logEntityOperation('reject_proposal', 'article_proposal', $proposal->id, true, auth()->id());

        return back()->with('success', 'پیشنهاد با موفقیت رد شد.');
    }

    public function destroyProposal($id)
    {
        $proposal = ArticleProposal::findOrFail($id);

        if ($proposal->file) {
            $filePath = storage_path('app/public/' . $proposal->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($proposal->abstract_file) {
            $filePath = storage_path('app/public/' . $proposal->abstract_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $proposal->delete();

        $this->logger->logDataDelete('article_proposals', $proposal->id, [
            'title' => $proposal->title,
            'user_id' => $proposal->user_id,
            'status' => $proposal->status,
        ], auth()->id());

        return back()->with('success', 'پیشنهاد با موفقیت حذف شد.');
    }
}
