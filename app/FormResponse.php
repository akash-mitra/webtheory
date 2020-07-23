<?php

namespace App;

use App\Mail\FormResponseNotification;
use Illuminate\Database\Eloquent\Model;
// use App\Jobs\SendEmail;
use App\Traits\SetMailConfig;

class FormResponse extends Model
{
    use SetMailConfig;
    
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
        $users = User::where('role', 'admin')->get();

        foreach ($users as $user) {
            if ($user->receiveMail()) {
                $this->sendEmail($user->email, new FormResponseNotification($this));
            }
        }
    }
}
