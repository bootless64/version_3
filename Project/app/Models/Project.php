<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'applicant_id',
        'primary_coach_id',
        'secondary_coach_id',

        'title',
        'status',

        'request_submission',
        'initial_audit',
        'contract_signing',
        'testing_and_monitoring',
        'final_confirmation',
        'final_report_submission',
        'end_of_contract',
    ];

    protected $casts = [
        'applicant_id' => 'integer',
        'primary_coach_id' => 'integer',
        'secondary_coach_id' => 'integer',
    ];

    public function applicant() {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function primaryCoach() {
        return $this->belongsTo(User::class, 'primary_coach_id');
    }

    public function secondaryCoach() {
        return $this->belongsTo(User::class, 'secondary_coach_id');
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

}
