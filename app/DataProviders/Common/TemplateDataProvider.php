<?php


namespace App\DataProviders\Common;


use App\Template;
use Illuminate\Support\Facades\Cache;

class TemplateDataProvider
{
    private object $parameters;

    public function __construct()
    {
        $this->parameters = Cache::rememberForever('template.parameters', function () {
            $param = optional(Template::where('active', '=',1)->first())->parameters;
            $array = (array) json_decode($param, true);
            return (object) array_column($array, 'value', 'name');
        });
    }

    /**
     * Returns an object that contains the template
     * variables as properties.
     *
     * @return object
     */
    public function vars(): object
    {
        return $this->parameters;
    }

    public function themeColor(): string
    {
        return optional($this->vars())->themeColor ?? '#fff';
    }

}
