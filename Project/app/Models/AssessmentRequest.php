<?php

namespace App\Models;

use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'security_assessment',
        'quality_assessment',

        'person_type',
        'applicant_name',
        'applicant_national_id',
        'applicant_economic_code',
        'applicant_landline_phone',
        'applicant_mobile_phone',
        'applicant_email',
        'applicant_fax',

        'manager_name',
        'manager_national_id',
        'manager_phone',
        'manager_email',
        'technical_manager_name',
        'technical_manager_national_id',
        'technical_manager_phone',
        'technical_manager_email',

        'product_type',
        'product_name',
        'product_brand_name',
        'software_version',
        'client_server',
        'mobile_application',
        'desktop_application',
        'web_application',
        'product_description',
        'file',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function checklist(){
        return $this->hasOne(AssessmentRequestChecklist::class);
    }

    public function getCreatedAt(){

        $date = Jalalian::fromDateTime($this->created_at)->format('Y/m/d H:i:s');

        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $date = str_replace($en, $fa, $date);

        return $date;
    }
}
