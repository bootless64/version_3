<?php

namespace App\Models;

use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['subject', 'message', 'status', 'response', 'category', 'priority', 'receiver_role'];

    protected $casts = [
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
        'project_id' => 'integer',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getCreatedAt()
    {
        $date = Jalalian::fromDateTime($this->created_at)->format('Y/m/d H:i:s');

        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $date = str_replace($en, $fa, $date);

        return $date;
    }
}