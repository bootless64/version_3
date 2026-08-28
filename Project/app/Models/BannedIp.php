<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannedIp extends Model
{
    protected $fillable = ['ip', 'reason', 'banned_by'];

    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public static function isBanned(string $ip): bool
    {
        return static::where('ip', $ip)->exists();
    }
}
