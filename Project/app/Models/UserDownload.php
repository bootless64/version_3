<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'order_id',
        'downloaded_at',
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}