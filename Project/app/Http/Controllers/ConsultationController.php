<?php

namespace App\Http\Controllers;

use App\Models\ConsultationRequest;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'service_type' => 'required|in:ISO15408,ISO25000,penetration_test,document_management',
        ], [
            'company_name.required' => 'نام شرکت الزامی است.',
            'phone.required'        => 'شماره تماس الزامی است.',
            'email.email'           => 'فرمت ایمیل صحیح نیست.',
            'service_type.required' => 'انتخاب نوع خدمت الزامی است.',
            'service_type.in'       => 'نوع خدمت انتخاب‌شده معتبر نیست.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'consultation')
                ->withInput();
        }

        $consultation = ConsultationRequest::create($request->only('company_name', 'phone', 'email', 'service_type'));

        $this->logger->logDataCreate('consultation_requests', $consultation->id, [
            'company_name' => $consultation->company_name,
            'service_type' => $consultation->service_type,
            'status' => $consultation->status
        ], null);

        return back()->with('consultation_success', 'درخواست مشاوره شما ثبت شد. در اسرع وقت با شما تماس می‌گیریم.');
    }

    public function index(Request $request)
    {
        $query = ConsultationRequest::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('company_name')) {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        }
        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        $consultations = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->only(['status', 'company_name', 'service_type']));

        return view('dashboard.manage-consultations', compact('consultations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,responded',
        ]);

        $consultation = ConsultationRequest::findOrFail($id);
        $oldStatus = $consultation->status;
        $consultation->status = $request->status;
        $consultation->save();

        $this->logger->logEntityOperation('update_status', 'consultation_request', $consultation->id, true, auth()->id());

        return back()->with('success', 'وضعیت درخواست به‌روزرسانی شد.');
    }

    public function destroy($id)
    {
        $consultation = ConsultationRequest::findOrFail($id);
        
        $this->logger->logDataDelete('consultation_requests', $consultation->id, [
            'company_name' => $consultation->company_name,
            'service_type' => $consultation->service_type,
            'status' => $consultation->status
        ], auth()->id());
        
        $consultation->delete();

        return back()->with('success', 'درخواست مشاوره حذف شد.');
    }
}
