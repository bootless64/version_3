<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_number',
        'email',
        'password',
        'login_attempts',
        'locked_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'locked_until'      => 'datetime',
    ];

    public function news(){
        return $this->hasMany(News::class);
    }

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function assessmentRequest(){
        return $this->hasMany(AssessmentRequest::class);
    }

    public function projectsAsApplicant(){
        return $this->hasMany(Project::class, 'applicant_id');
    }

    public function projectsAsPrimaryCoach(){
        return $this->hasMany(Project::class, 'primary_coach_id');
    }

    public function projectsAsSecondaryCoach(){
        return $this->hasMany(Project::class, 'secondary_coach_id');
    }

    public function ticketsAsSender(){
        return $this->hasMany(Ticket::class, 'sender_id');
    }

    public function ticketsAsReceiver(){
        return $this->hasMany(Ticket::class, 'receiver_id');
    }

}
