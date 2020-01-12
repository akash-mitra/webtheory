<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['name', 'description', 'type', 'active', 'media_url', 'user_id'];


}
