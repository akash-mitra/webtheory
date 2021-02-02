<?php

namespace App;

use App\Mail\FormResponseNotification;
use App\Traits\CustomEmailSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use App\Jobs\SendEmail;

class FormResponse extends Model
{
    use CustomEmailSetup;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['form_id', 'ip', 'responses'];

    /**
     * @return BelongsTo
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    /**
     * Send email to all the site admins with the form response.
     */
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
