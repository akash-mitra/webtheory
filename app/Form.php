<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status', 'captcha', 'fields', 
    ];

    protected $appends = ['created_ago', 'updated_ago'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'captcha' => 'boolean',
    ];

    public function getCreatedAgoAttribute()
    {
        return empty($this->created_at)? null : $this->created_at->diffForHumans();
    }

    public function getUpdatedAgoAttribute()
    {
        return empty($this->updated_at)? null : $this->updated_at->diffForHumans();
    }
    
    public function formResponses()
    {
        return $this->hasMany('App\FormResponse');
    }

    public function hasFormResponses()
    {
        return $this->formResponses()->count();
    }
}
