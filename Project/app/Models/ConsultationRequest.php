<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'phone',
        'email',
        'service_type',
        'status',
    ];

    public function getServiceTypeLabelAttribute(): string
    {
        return match($this->service_type) {
            'ISO15408'            => 'استاندارد ISO/IEC 15408',
            'ISO25000'            => 'استاندارد ISO/IEC 25000',
            'penetration_test'    => 'تست نفوذ و امنیت',
            'document_management' => 'تنظیم و پایش اسناد',
            default               => $this->service_type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'پاسخ داده نشده',
            'responded'  => 'پاسخ داده شده',
            default      => $this->status,
        };
    }
}
