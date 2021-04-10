<?php

namespace App;

use App\Traits\RelativeTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * App\Form
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $status
 * @property bool $captcha
 * @property string $fields
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|FormResponse[] $formResponses
 * @property-read int|null $form_responses_count
 * @property-read null|string $created_ago
 * @property-read null|string $updated_ago
 * @method static Builder|Form newModelQuery()
 * @method static Builder|Form newQuery()
 * @method static Builder|Form query()
 * @method static Builder|Form whereCaptcha($value)
 * @method static Builder|Form whereCreatedAt($value)
 * @method static Builder|Form whereDescription($value)
 * @method static Builder|Form whereFields($value)
 * @method static Builder|Form whereId($value)
 * @method static Builder|Form whereName($value)
 * @method static Builder|Form whereStatus($value)
 * @method static Builder|Form whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Form extends Model
{
    use RelativeTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'status', 'captcha', 'fields'];

    protected $appends = ['url', 'permalink', 'created_ago', 'updated_ago'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'captcha' => 'boolean',
        'fields' => 'array',
    ];

    /**
     * Returns a list of form responses.
     * @return HasMany
     */
    public function formResponses(): HasMany
    {
        return $this->hasMany(FormResponse::class);
    }

    /**
     * Returns true if the form contains any response.
     * @return bool
     */
    public function hasResponses(): bool
    {
        return $this->formResponses()->count() > 0;
    }

    /**
     * Returns an array containing all the user defined form fields.
     *
     * @return array
     */
    public function currentFields(): array
    {
        return array_map(function ($field) {
            return $field['name'];
        }, $this->fields);
    }

    /**
     * Returns an array containing all the user
     * defined validation rules for all the fields.
     *
     * @return array
     */
    public function fieldValidationRules(): array
    {
        $validations = array_map(function ($field) {
            return $field['validation'] ?? '';
        }, $this->fields);

        return array_combine($this->currentFields(), $validations);
    }

    public function getUrlAttribute()
    {
        return url('forms/' . $this->id . '/' . Str::slug($this->name));
    }

    public function getPermalinkAttribute()
    {
        return url('forms/' . $this->id);
    }
}
