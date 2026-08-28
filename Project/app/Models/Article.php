<?php

namespace App\Models;

use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'title',
        'content',
        'image',
        'file',
        'user_id',
        'status',
        'keywords',
        'authors',
        'publication_year',
        'abstract_file',
        'is_published',
        'description',
        'admin_note',
        'price',
        'is_free',
        'price_set_by',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'is_published' => 'boolean',
        'is_free' => 'boolean',
        'price' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priceSetter()
    {
        return $this->belongsTo(User::class, 'price_set_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isPurchasedByUser($userId)
    {
        return UserDownload::where('user_id', $userId)
            ->where('article_id', $this->id)
            ->exists();
    }

    public function getPriceFormattedAttribute()
    {
        if ($this->is_free) {
            return 'رایگان';
        }
        return number_format($this->price) . ' تومان';
    }

    public function getCreatedAt()
    {
        $date = Jalalian::fromDateTime($this->created_at)->format('Y/m/d');

        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $date = str_replace($en, $fa, $date);

        return $date;
    }

    public function getTypeLabelAttribute()
    {
        $types = [
            'national' => 'بومی',
            'international' => 'بین‌المللی',
            'local' => 'بومی'
        ];
        return $types[$this->type] ?? $this->type;
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'در انتظار بررسی',
            'approved' => 'تایید شده',
            'rejected' => 'رد شده'
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getTypeBadgeClassAttribute()
    {
        $classes = [
            'national' => 'bg-success',
            'international' => 'bg-primary',
            'local' => 'bg-success'
        ];
        return $classes[$this->type] ?? 'bg-secondary';
    }

    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'bg-warning text-dark',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger'
        ];
        return $classes[$this->status] ?? 'bg-secondary';
    }
}