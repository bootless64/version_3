<?php

namespace App\Models;

use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'image', 'slider_images', 'user_id'];

    protected $casts = [
        'slider_images' => 'array',
        'user_id' => 'integer',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(){
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function getCreatedAt(){

        $date = Jalalian::fromDateTime($this->created_at)->format('Y/m/d');

        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $date = str_replace($en, $fa, $date);

        return $date;
    }

}
