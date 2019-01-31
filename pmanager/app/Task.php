<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
        'name',
        'project_id',
        'user_id',
        'days',
        'hours',
        'company_id',
    ];

    public function user()
    {
        return $this->belongs('App\User');
    }

    public function project()
    {
        return $this->belongs('App\Project');
    }

    public function company()
    {
        return $this->belongs('App\Company');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}

