<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'status',
        'transaction_id',
        'total_amount',
        'payment_method',
        'paid_at',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'terms_accepted',
        'admin_note',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'terms_accepted' => 'boolean',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function downloads()
    {
        return $this->hasMany(UserDownload::class);
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'در انتظار پرداخت',
            'paid' => 'پرداخت شده',
            'failed' => 'ناموفق',
            'expired' => 'منقضی شده',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'bg-warning text-dark',
            'paid' => 'bg-success',
            'failed' => 'bg-danger',
            'expired' => 'bg-secondary',
        ];
        return $classes[$this->status] ?? 'bg-secondary';
    }
}