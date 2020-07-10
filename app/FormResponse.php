<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id', 'ip', 'responses',
    ];

    public function form()
    {
        return $this->belongsTo('App\Form', 'form_id');
    }
}
