<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['content', 'user_id', 'news_id', 'article_id'];

    protected $casts = [
        'user_id' => 'integer',
        'news_id' => 'integer',
        'article_id' => 'integer',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function news(){
        return $this->belongsTo(News::class);
    }

    public function article(){
        return $this->belongsTo(Article::class);
    }
}
