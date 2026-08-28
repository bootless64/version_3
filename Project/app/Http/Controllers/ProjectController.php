<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function manageProjects(Request $request)
    {
        $query = Project::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%'.$request->title.'%');
        }
        if ($request->filled('applicant_name')) {
            $query->whereHas('applicant', function($q) use ($request){
                $q->where('name', 'like', '%'.$request->applicant_name.'%');
            });
        }
        if ($request->filled('primary_coach_name')) {
            $query->whereHas('primaryCoach', function($q) use ($request){
                $q->where('name', 'like', '%'.$request->primary_coach_name.'%');
            });
        }

        $projects = $query->orderBy('id','desc')->paginate(20)
                      ->appends($request->only(['id','title','applicant_name','primary_coach_name']));

        return view('dashboard.manage-projects.index', compact('projects'));
    }

    public function projectReports($id)
    {
        $project = Project::with(['applicant', 'primaryCoach', 'secondaryCoach'])->findOrFail($id);
        return view('dashboard.manage-projects.reports', compact('project'));
    }

    public function create()
    {
        $coaches = User::role(['admin', 'coach'])->get();
        return view('dashboard.manage-projects.create', compact('coaches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'applicant_id' => 'required|integer|exists:users,id',
            'assessment_request_id' => 'nullable|integer|exists:assessment_requests,id',
            'primary_coach_id' => 'required|integer|exists:users,id',
            'secondary_coach_id' => 'nullable|integer|exists:users,id',
            'title' => 'required|string|max:100',
            'status' => 'required|in:request_submission,initial_audit,contract_signing,testing_and_monitoring,final_confirmation,final_report_submission,end_of_contract',

            'request_submission' => 'nullable|string',
            'request_submission_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            'initial_audit' => 'nullable|string',
            'initial_audit_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            'contract_signing' => 'nullable|string',
            'contract_signing_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            'testing_and_monitoring' => 'nullable|string',
            'testing_and_monitoring_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            'final_confirmation' => 'nullable|string',
            'final_confirmation_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            'final_report_submission' => 'nullable|string',
            'final_report_submission_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            'end_of_contract' => 'nullable|string',
            'end_of_contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $project = new Project();

        $project->applicant_id = $validated['applicant_id'];
        $project->assessment_request_id = $validated['assessment_request_id'];
        $project->primary_coach_id = $validated['primary_coach_id'];
        $project->secondary_coach_id = $validated['secondary_coach_id'];
        $project->title = $validated['title'];
        $project->status = $validated['status'];

        $project->request_submission = $validated['request_submission'];
        $project->initial_audit = $validated['initial_audit'];
        $project->contract_signing = $validated['contract_signing'];
        $project->testing_and_monitoring = $validated['testing_and_monitoring'];
        $project->final_confirmation = $validated['final_confirmation'];
        $project->final_report_submission = $validated['final_report_submission'];
        $project->end_of_contract = $validated['end_of_contract'];

        $files = ['request_submission_file', 'initial_audit_file', 'contract_signing_file', 'testing_and_monitoring_file', 'final_confirmation_file', 'final_report_submission_file', 'end_of_contract_file'];
        $uploaded_file_names = [];

        foreach ($files as $file) {
            if ($request->hasFile($file))
            {
                $filename = $validated[$file]->getClientOriginalName();
                if (in_array($filename, $uploaded_file_names)) {
                    return back()->with('error', 'دو فایل با نام یکسان ' . $filename . ' ارسال شده‌اند.')->withInput();
                }
                $uploaded_file_names[] = $filename;
            }
        }

        $project->save();

        foreach ($files as $file) {
            if ($request->hasFile($file))
            {
                $filename = $validated[$file]->getClientOriginalName();
                $validated[$file]->storeAs("private/project_files/{$project->id}", $filename);
                $project->$file = $filename;
            }
        }

        $project->save();

        return redirect()->route('dashboard.manage-projects.index')->with('success', 'پروژه با موفقیت ایجاد شد.');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $coaches = User::role(['admin', 'coach'])->get();

        return view('dashboard.manage-projects.edit', compact('project', 'coaches'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'applicant_id' => 'required|integer|exists:users,id',
            'assessment_request_id' => 'nullable|integer|exists:assessment_requests,id',
            'primary_coach_id' => 'required|integer|exists:users,id',
            'secondary_coach_id' => 'nullable|integer|exists:users,id',
            'title' => 'required|string|max:100',
            'status' => 'required|in:request_submission,initial_audit,contract_signing,testing_and_monitoring,final_confirmation,final_report_submission,end_of_contract',

            'request_submission' => 'nullable|string',
            'request_submission_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'remove_request_submission_file' => 'sometimes|boolean',

            'initial_audit' => 'nullable|string',
            'initial_audit_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'remove_initial_audit_file' => 'sometimes|boolean',

            'contract_signing' => 'nullable|string',
            'contract_signing_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'remove_contract_signing_file' => 'sometimes|boolean',

            'testing_and_monitoring' => 'nullable|string',
            'testing_and_monitoring_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'remove_testing_and_monitoring_file' => 'sometimes|boolean',

            'final_confirmation' => 'nullable|string',
            'final_confirmation_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'remove_final_confirmation_file' => 'sometimes|boolean',

            'final_report_submission' => 'nullable|string',
            'final_report_submission_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'remove_final_report_submission_file' => 'sometimes|boolean',

            'end_of_contract' => 'nullable|string',
            'end_of_contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'remove_end_of_contract_file' => 'sometimes|boolean',
        ]);

        $project = Project::findOrFail($id);

        $project->applicant_id = $validated['applicant_id'];
        $project->assessment_request_id = $validated['assessment_request_id'];
        $project->primary_coach_id = $validated['primary_coach_id'];
        $project->secondary_coach_id = $validated['secondary_coach_id'];
        $project->title = $validated['title'];
        $project->status = $validated['status'];

        $project->request_submission = $validated['request_submission'];
        $project->initial_audit = $validated['initial_audit'];
        $project->contract_signing = $validated['contract_signing'];
        $project->testing_and_monitoring = $validated['testing_and_monitoring'];
        $project->final_confirmation = $validated['final_confirmation'];
        $project->final_report_submission = $validated['final_report_submission'];
        $project->end_of_contract = $validated['end_of_contract'];

        $files = ['request_submission_file', 'initial_audit_file', 'contract_signing_file', 'testing_and_monitoring_file', 'final_confirmation_file', 'final_report_submission_file', 'end_of_contract_file'];
        $uploaded_file_names = [];

        foreach ($files as $file) {
            if ($request->hasFile($file))
            {
                $filename = $validated[$file]->getClientOriginalName();
                if (in_array($filename, $uploaded_file_names)) {
                    return back()->with('error', 'دو فایل با نام یکسان ' . $filename . ' ارسال شده‌اند.')->withInput();
                }
                $uploaded_file_names[] = $filename;

                if (Storage::exists("private/project_files/{$project->id}/" . $filename)) {
                    return back()->with('error', 'فایلی با نام ' . $filename . ' قبلا برای این پروژه ذخیره شده است.')->withInput();
                }
            }
        }

        foreach ($files as $file) {
            if ($request->has('remove_' . $file) && $project->$file) {
                Storage::delete("private/project_files/{$project->id}/" . $project->$file);
                $project->$file = null;
            }

            if ($request->hasFile($file)) {
                if ($project->$file) {
                    Storage::delete("private/project_files/{$project->id}/" . $project->$file);
                }
                $filename = $validated[$file]->getClientOriginalName();
                $validated[$file]->storeAs("private/project_files/{$project->id}", $filename);
                $project->$file = $filename;
            }
        }

        $project->save();

        return redirect()->route('dashboard.manage-projects.index')->with('success', 'پروژه با موفقیت ویرایش شد.');
    }

    public function downloadFile($id, $file)
    {
        if (Storage::exists('private/project_files/' . $id . '/' . $file))
        {
            return Storage::download('private/project_files/' . $id . '/' . $file);
        }
        return abort(404);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        $this->logger->logDataDelete('projects', $project->id, [
            'project_id' => $project->id,
            'title' => $project->title,
            'applicant_id' => $project->applicant_id
        ], auth()->id());

        if (Storage::exists('private/project_files/' . $id))
        {
            Storage::deleteDirectory('private/project_files/' . $id);
        }

        $project->delete();
        return back()->with('success', 'پروژه مورد نظر حذف شد.');
    }

    public function myProjects()
    {
        /** @var User $user*/
        $user = auth()->user();
        $projects_as_applicant = $user->projectsAsApplicant()->latest()->get();
        $projects_as_primary_coach = $user->projectsAsPrimaryCoach()->latest()->get();
        $projects_as_secondary_coach = $user->projectsAsSecondaryCoach()->latest()->get();

        $projects_as_coach = $projects_as_primary_coach->merge($projects_as_secondary_coach)->unique('id');

        return view('dashboard.my-projects.index', compact('projects_as_applicant', 'projects_as_coach'));
    }

    public function myProjectReports($id)
    {
        $project = Project::with(['applicant', 'primaryCoach', 'secondaryCoach'])->findOrFail($id);

        $user_id = auth()->id();

        if ($user_id === $project->applicant_id || $user_id === $project->primary_coach_id || $user_id === $project->secondary_coach_id)
        {
            return view('dashboard.my-projects.reports', compact('project'));
        }

        return abort(403);
    }

    public function downloadMyProjectFile($id, $file)
    {
        $project = Project::findOrFail($id);
        if (auth()->id() === $project->applicant_id || auth()->id() === $project->primary_coach_id || auth()->id() === $project->secondary_coach_id)
        {
            if (Storage::exists('private/project_files/' . $id . '/' . $file))
            {
                return Storage::download('private/project_files/' . $id . '/' . $file);
            }
            return abort(404);
        }
        return abort(403);
    }

    public function myProjectTickets($id)
    {
        $project = Project::with(['applicant', 'primaryCoach', 'secondaryCoach'])->findOrFail($id);

        $user_id = auth()->id();

        if ($user_id === $project->applicant_id || $user_id === $project->primary_coach_id || $user_id === $project->secondary_coach_id)
        {
            $tickets = $project->tickets;
            return view('dashboard.my-projects.tickets', compact('project', 'tickets'));
        }

        return abort(403);
    }
}
