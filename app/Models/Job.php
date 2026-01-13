<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
     protected $table = 'jobs'; 
    protected $fillable = [
        'recruiter_id',
        'title',
        'skills',
        'description',
    ]; 
    public $timestamps = false;
}
