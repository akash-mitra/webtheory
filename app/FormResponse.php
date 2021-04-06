<?php

namespace App;

use App\Mail\FormResponseNotification;
use App\Traits\CustomEmailSetup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

// use App\Jobs\SendEmail;

/**
 * App\FormResponse
 *
 * @property int $id
 * @property int $form_id
 * @property string $ip
 * @property string $responses
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Form $form
 * @method static Builder|FormResponse newModelQuery()
 * @method static Builder|FormResponse newQuery()
 * @method static Builder|FormResponse query()
 * @method static Builder|FormResponse whereCreatedAt($value)
 * @method static Builder|FormResponse whereFormId($value)
 * @method static Builder|FormResponse whereId($value)
 * @method static Builder|FormResponse whereIp($value)
 * @method static Builder|FormResponse whereResponses($value)
 * @method static Builder|FormResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
