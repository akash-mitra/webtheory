<?php

namespace App;

use App\Page;
use App\Template;
use App\Category;
use App\Parameter;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class DataProvider
{
    public static function home()
    {
        return (object) [
            'ref' => self::ref('home'),
            'pages' => self::pages(),
            'categories' => self::categories(),
            'user' => auth()->user(),
        ];
    }

    public static function single($id)
    {
        $page = Page::with(['content', 'author', 'category'])
            ->published()
            ->findOrFail($id);

        return (object) [
            'ref' => self::ref('single'),
            'page' => $page,
            'categories' => self::categories(),
            'user' => auth()->user(),
        ];
    }

    public static function category($id)
    {
        $category = Category::with([
            'author',
            'subcategories',
            'pages' => function ($q) {
                $q->published();
            },
            'parent',
        ])->findOrFail($id);

        return (object) [
            'ref' => self::ref('category'),
            'category' => $category,
            'user' => auth()->user(),
        ];
    }

    public static function profile($user)
    {
        return (object) [
            'ref' => self::ref('profile'),
            'profile' => (object) $user,
            'user' => auth()->user(),
        ];
    }

    public static function custom()
    {
        return (object) [
            'ref' => self::ref('custom'),
            'pages' => self::pages(),
            'categories' => self::categories(),
            'user' => auth()->user(),
        ];
    }

    public static function categories()
    {
        return Cache::rememberForever('categories', function () {
            return Category::with('author')->get();
        });
    }

    public static function pages($howMany = 15)
    {
        /*
         * Only cache if request does not have any pagination parameter.
         *
         * Alternatively, we could create different cache keys for
         * different pages of the pagination. But that approach
         * will open the door to cache flooding attack by
         * continuously sending different values for the
         * pagination parmeters from the web. Another
         * issue is such proliferation of the cache
         * keys, will make invalidations complex.
         */

        if (empty(request('page'))) {
            return Cache::rememberForever('pages', function () use ($howMany) {
                return Page::with(['author', 'category'])
                    ->published()
                    ->latest()
                    ->paginate($howMany);
            });
        }

        return Page::with(['author', 'category'])
            ->published()
            ->latest()
            ->paginate($howMany);
    }

    public static function ref(string $contentType): object
    {
        return (object) [
            'contentType' => $contentType,
            'template' => self::template(),
            'site' => self::site(),
            'share' => self::share(),
            'login' => (object) [
                'socialprovider' => json_decode(Parameter::getKey('socialprovider'), false),
            ],
        ];
    }

    /*
     * Returns the template parameters pertaining
     * to the active template of the given type.
     */
    public static function template(): object
    {
        return Cache::rememberForever('template.parameters', function () {
            $param = optional(Template::where('active', 1)->first())->parameters;

            $array = (array) json_decode($param, true);

            return (object) array_column($array, 'value', 'name');
        });
    }

    public static function site(): object
    {
        return (object) json_decode(Parameter::getKey('siteinfo'));
    }

    public static function share(): object
    {
        return (object) json_decode(Parameter::getKey('share'));
    }

    public static function keylist(): array
    {
        return [
            'template.parameters',

            'parameters.siteinfo',

            'pages',
            'categories',
            'categories.lov',
        ];
    }

    public static function keys(): array
    {
        Redis::select('1');

        $keys = Redis::keys('*');

        sort($keys);

        return $keys;
    }
}
