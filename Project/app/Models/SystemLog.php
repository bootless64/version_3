<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_time',
        'event_type',
        'event_category',
        'event_result',
        'user_id',
        'user_name',
        'user_ip',
        'user_agent',
        'session_id',
        'method',
        'url',
        'route_name',
        'description',
        'details',
        'error_message',
        'affected_entity',
        'affected_entity_id',
    ];

    protected $casts = [
        'event_time' => 'datetime',
        'event_result' => 'boolean',
        'details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getResultLabelAttribute()
    {
        return $this->event_result ? 'موفق' : 'ناموفق';
    }

    public function getResultBadgeClassAttribute()
    {
        return $this->event_result ? 'bg-success' : 'bg-danger';
    }
}