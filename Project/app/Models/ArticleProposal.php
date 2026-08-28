<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleProposal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'submission_type',
        'title',
        'authors',
        'student_name',
        'supervisor',
        'research_field',
        'keywords',
        'description',
        'title_explanation',
        'similar_status',
        'similar_year',
        'similar_place',
        'similar_link',
        'type',
        'publication_year',
        'defense_year',
        'thesis_type',
        'file',
        'abstract_file',
        'status',
        'admin_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'در انتظار تایید',
            'approved' => 'تایید شده',
            'rejected' => 'رد شده'
        ];
        return $statuses[$this->status] ?? $this->status;
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
