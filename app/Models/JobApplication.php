<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $table = 'job_applications'; 
    protected $fillable = [
        'job_id',
        'candidate_id',
        'resume',
        'skills',
        'stage',
        'resume_score',
        'github_score', 
        'score',
        'git_lang',
        'tech_score',
        'tech_comment',
        'hr_score',
        'hr_comment'
    ]; 
    public $timestamps = false;
    public function candidate()
{
    return $this->belongsTo(Users::class, 'candidate_id');
}

public function job()
{
    return $this->belongsTo(Job::class, 'job_id');
}
}
