<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentRequestChecklist extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'qa_product_catalog',
        'qa_user_manual',
        'qa_basic_procedures_description',
        'qa_product_security_requirements',
        'qa_product_release_version',
        'qa_product_architecture',
        'qa_database_documentation',
        'qa_non_functional_requirements',
        'qa_system_diagrams',
        'qa_questionnaire',
        'qa_manufacturer_info',
        'qa_maintenance_manual',
        'qa_communication_protocols',
        'qa_programming_environment',

        'sa_product_catalog',
        'sa_user_manual',
        'sa_product_identity',
        'sa_product_security_requirements',
        'sa_analysis_design_doc',
        'sa_product_architecture',
        'sa_security_target_doc',
        'sa_product_release_version',
        'sa_agd',
        'sa_alc',
        'sa_adv',
        'sa_crypto_capability_declaration',
    ];

    protected $casts = [
        'assessment_request_id' => 'integer',
    ];

    public function assessmentRequest(){
        return $this->belongsTo(AssessmentRequest::class);
    }
}
