<?php

namespace App;

use App\Mail\FormResponseNotification;
use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['form_id', 'ip', 'responses'];

    public function form()
    {
        return $this->belongsTo('App\Form', 'form_id');
    }

    public function email()
    {
        //TODO rewrite the whereJsonContains part

        // $users = User::where('role', 'admin')
        //     ->whereJsonContains('preferences', 'mail')
        //     ->get();

        // foreach ($users as $user) {
        //     $this->sendEmail($user->email, new FormResponseNotification($this));
        // }
    }
}
