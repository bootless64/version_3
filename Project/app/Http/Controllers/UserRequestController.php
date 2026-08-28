<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\AssessmentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\AssessmentRequestChecklist;

class UserRequestController extends Controller
{
    public function index()
    {
        return view('dashboard.requests.index');
    }

    public function assessment()
    {
        $temp_number = DB::table('assessment_requests')->max('id') + 1 ?? 1;
        $date = Jalalian::now()->format('Y/m/d');

        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $temp_number = str_replace($en, $fa, $temp_number);
        $date = str_replace($en, $fa, $date);

        return view('dashboard.requests.assessment', compact('temp_number', 'date'));
    }

    public function storeAssessmentRequest(Request $request)
    {
        $validated = $request->validate([
            'security_assessment' => 'sometimes|boolean',
            'quality_assessment' => 'sometimes|boolean',

            'person_type' => 'required|in:natural_person,legal_person',
            'applicant_name' => 'required|string|max:25',
            'applicant_national_id' => 'nullable|string|max:25',
            'applicant_economic_code' => 'nullable|string|max:25',
            'applicant_landline_phone' => 'nullable|string|max:25',
            'applicant_mobile_phone' => 'nullable|string|max:25',
            'applicant_email' => 'nullable|string|email|max:50',
            'applicant_fax' => 'nullable|string|max:25',

            'manager_name' => 'nullable|string|max:25',
            'manager_national_id' => 'nullable|string|max:25',
            'manager_phone' => 'nullable|string|max:25',
            'manager_email' => 'nullable|string|email|max:50',
            'technical_manager_name' => 'nullable|string|max:25',
            'technical_manager_national_id' => 'nullable|string|max:25',
            'technical_manager_phone' => 'nullable|string|max:25',
            'technical_manager_email' => 'nullable|string|email|max:50',

            'product_type' => 'in:local,non_local',
            'product_name' => 'required|string|max:25',
            'product_brand_name' => 'nullable|string|max:25',
            'software_version' => 'nullable|string|max:25',
            'client_server' => 'sometimes|boolean',
            'mobile_application' => 'sometimes|boolean',
            'desktop_application' => 'sometimes|boolean',
            'web_application' => 'sometimes|boolean',
            'product_description' => 'nullable|string|max:255',

            'file' => 'nullable|file|mimes:zip,rar|max:25600',
        ], [
            'file.max' => 'حجم فایل نباید بیشتر از 25 مگابایت باشد.',
        ]);

        $assessment_request = new AssessmentRequest();

        $assessment_request->user_id = auth()->id();

        $assessment_request->security_assessment = $validated['security_assessment'] ?? 0;
        $assessment_request->quality_assessment = $validated['quality_assessment'] ?? 0;

        $assessment_request->person_type = $validated['person_type'];
        $assessment_request->applicant_name = $validated['applicant_name'];
        $assessment_request->applicant_national_id = $validated['applicant_national_id'];
        $assessment_request->applicant_economic_code = $validated['applicant_economic_code'];
        $assessment_request->applicant_landline_phone = $validated['applicant_landline_phone'];
        $assessment_request->applicant_mobile_phone = $validated['applicant_mobile_phone'];
        $assessment_request->applicant_email = $validated['applicant_email'];
        $assessment_request->applicant_fax = $validated['applicant_fax'];

        $assessment_request->manager_name = $validated['manager_name'];
        $assessment_request->manager_national_id = $validated['manager_national_id'];
        $assessment_request->manager_phone = $validated['manager_phone'];
        $assessment_request->manager_email = $validated['manager_email'];
        $assessment_request->technical_manager_name = $validated['technical_manager_name'];
        $assessment_request->technical_manager_national_id = $validated['technical_manager_national_id'];
        $assessment_request->technical_manager_phone = $validated['technical_manager_phone'];
        $assessment_request->technical_manager_email = $validated['technical_manager_email'];

        $assessment_request->product_type = $validated['product_type'] ?? 'local';
        $assessment_request->product_name = $validated['product_name'];
        $assessment_request->product_brand_name = $validated['product_brand_name'];
        $assessment_request->software_version = $validated['software_version'];
        $assessment_request->client_server = $validated['client_server'] ?? 0;
        $assessment_request->mobile_application = $validated['mobile_application'] ?? 0;
        $assessment_request->desktop_application = $validated['desktop_application'] ?? 0;
        $assessment_request->web_application = $validated['web_application'] ?? 0;
        $assessment_request->product_description = $validated['product_description'];

        if ($request->hasFile('file')) {
            $file = $validated['file'];
            $filename = auth()->id() . '_' . Carbon::now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('private/assessment_request_files', $filename);
            $assessment_request->file = $filename;
        }

        $assessment_request->save();

        return redirect()->route('dashboard.requests.assessment.checklist', $assessment_request->id);
    }

    public function assessmentChecklist($id)
    {
        $assessment_request = AssessmentRequest::findOrFail($id);

        if ($assessment_request->checklist) {
            return redirect()->route('dashboard.requests.index')->with('error', 'چک لیست درخواست قبلا ثبت شده است.');
        }

        if (auth()->id() === $assessment_request->user_id)
        {
            return view('dashboard.requests.assessment-checklist', compact('assessment_request'));
        }

        return abort(403);
    }

    public function storeAssessmentChecklist(Request $request, $assessment_request_id)
    {
        $assessment_request = AssessmentRequest::findOrFail($assessment_request_id);

        if (auth()->id() !== $assessment_request->user_id)
        {
            return abort(403);
        }

        if ($assessment_request->checklist) {
            return redirect()->route('dashboard.requests.index')->with('error', 'چک لیست درخواست قبلا ثبت شده است.');
        }

        $validated = $request->validate([
            'qa_product_catalog' => 'sometimes|boolean',
            'qa_user_manual' => 'sometimes|boolean',
            'qa_basic_procedures_description' => 'sometimes|boolean',
            'qa_product_security_requirements' => 'sometimes|boolean',
            'qa_product_release_version' => 'sometimes|boolean',
            'qa_product_architecture' => 'sometimes|boolean',
            'qa_database_documentation' => 'sometimes|boolean',
            'qa_non_functional_requirements' => 'sometimes|boolean',
            'qa_system_diagrams' => 'sometimes|boolean',
            'qa_questionnaire' => 'sometimes|boolean',
            'qa_manufacturer_info' => 'sometimes|boolean',
            'qa_maintenance_manual' => 'sometimes|boolean',
            'qa_communication_protocols' => 'sometimes|boolean',
            'qa_programming_environment' => 'sometimes|boolean',

            'sa_product_catalog' => 'sometimes|boolean',
            'sa_user_manual' => 'sometimes|boolean',
            'sa_product_identity' => 'sometimes|boolean',
            'sa_product_security_requirements' => 'sometimes|boolean',
            'sa_analysis_design_doc' => 'sometimes|boolean',
            'sa_product_architecture' => 'sometimes|boolean',
            'sa_security_target_doc' => 'sometimes|boolean',
            'sa_product_release_version' => 'sometimes|boolean',
            'sa_agd' => 'sometimes|boolean',
            'sa_alc' => 'sometimes|boolean',
            'sa_adv' => 'sometimes|boolean',
            'sa_crypto_capability_declaration' => 'sometimes|boolean',
        ]);

        $checklist = new AssessmentRequestChecklist();

        $checklist->assessment_request_id = $assessment_request_id;

        $fields = ['qa_product_catalog', 'qa_user_manual', 'qa_basic_procedures_description', 'qa_product_security_requirements', 'qa_product_release_version', 'qa_product_architecture', 'qa_database_documentation',
            'qa_non_functional_requirements', 'qa_system_diagrams', 'qa_questionnaire', 'qa_manufacturer_info', 'qa_maintenance_manual', 'qa_communication_protocols', 'qa_programming_environment',

            'sa_product_catalog', 'sa_user_manual', 'sa_product_identity', 'sa_product_security_requirements', 'sa_analysis_design_doc', 'sa_product_architecture',
            'sa_security_target_doc', 'sa_product_release_version', 'sa_agd', 'sa_alc', 'sa_adv', 'sa_crypto_capability_declaration',
        ];

        foreach ($fields as $field) {
            $checklist->$field = $validated[$field] ?? 0;
        }

        $checklist->save();

        return redirect()->route('dashboard.requests.index')->with('success', 'درخواست شما با موفقیت ثبت شد.');
    }

    public function manageRequests(Request $request)
    {
        $query = AssessmentRequest::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('user_name')) {
            $query->whereHas('user', function($q) use ($request){
                $q->where('name', 'like', '%'.$request->user_name.'%');
            });
        }
        if ($request->filled('product_name')) {
            $query->where('product_name', 'like', '%'.$request->product_name.'%');
        }

        $assessment_requests = $query->orderBy('created_at','desc')->paginate(25)
                          ->appends($request->only(['id','user_name','product_name']));

        return view('dashboard.manage-projects.manage-requests.index', compact('assessment_requests'));
    }

    public function showRequest($id)
    {
        $assessment_request = AssessmentRequest::findOrFail($id);
        $assessment_request_checklist = $assessment_request->checklist;

        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $date = Jalalian::fromDateTime($assessment_request->created_at)->format('Y/m/d');
        $fa_id = str_replace($en, $fa, $assessment_request->id);
        $fa_date = str_replace($en, $fa, $date);

        return view('dashboard.manage-projects.manage-requests.show', compact('assessment_request', 'assessment_request_checklist', 'fa_id', 'fa_date'));
    }

    public function downloadRequestFile($file)
    {
        if (Storage::exists('private/assessment_request_files/' . $file))
        {
            return Storage::download('private/assessment_request_files/' . $file);
        }
        return abort(404);
    }

    public function destroyRequest($id)
    {
        $assessment_requests = AssessmentRequest::findOrFail($id);

        if (Storage::exists('private/assessment_request_files/' . $assessment_requests->file))
        {
            Storage::delete('private/assessment_request_files/' . $assessment_requests->file);
        }

        $assessment_requests->delete();

        return back()->with('success', 'درخواست حذف شد.');
    }
}
