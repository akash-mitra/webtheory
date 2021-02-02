<?php

namespace App;

use App\Traits\RelativeTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    use RelativeTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'status', 'captcha', 'fields'];

    protected $appends = ['created_ago', 'updated_ago'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'captcha' => 'boolean',
    ];

    /**
     * Returns a list of form responses.
     * @return HasMany
     */
    public function formResponses(): HasMany
    {
        return $this->hasMany('App\FormResponse');
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
            return $field->name;
        }, json_decode($this->fields));
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
            return optional($field)->validation ?? '';
        }, json_decode($this->fields));

        return array_combine($this->currentFields(), $validations);
    }
}
