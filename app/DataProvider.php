<?php

namespace App;

use App\Page;
use App\Template;
use App\Category;
use App\Parameter;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class DataProvider {


    public static function home()
    {
        return (object) [
            "ref" => self::ref('home'),
            "pages" => self::pages(),
            "topics" => self::topics(),
            "user" => auth()->user()
        ];
    }



    public static function single($id)
    {
        $page = Page::with(['content', 'author', 'category'])->published()->findOrFail($id);

        return (object) [
            "ref" => self::ref('single'),
            "page" => $page,
            "topics" => self::topics(),
            "user" => auth()->user()
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
            'parent'
        ])->findOrFail($id);

        return (object) [
            "ref" => self::ref('category'),
            "category" => $category,
            "user" => auth()->user()
        ];
    }



    public static function topics ()
    {
        return Cache::rememberForever('categories', function () {

            return Category::with('author')->get();

        });
    }



    public static function pages ($howMany = 15)
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

                return Page::with(['author', 'category'])->published()->paginate($howMany);

            });
        }

        return Page::with(['author', 'category'])->published()->paginate($howMany);

    }




    public static function ref($type) : object
    {
        return (object) [

            "template" => self::template($type),
            "site" => self::site()
        ];
    }



    /*
     * Returns the template paramters pertaining
     * to the active template of the given type.
     */
    public static function template ($type) : object
    {
        return Cache::rememberForever('templates.' . $type, function () use ($type) {

            $param = optional(Template::where('type', $type)->where('active', 1)->first())->parameters;

            $array = (array) json_decode($param, true);

            return (object) array_column($array, 'value', 'name');
        });
    }



    public static function site () : object
    {
        return (object) json_decode(Parameter::getKey('siteinfo'));

    }



    public static function keylist () : array
    {
        return [
            'templates.home',
            'templates.single',
            'templates.category',
            'templates.profile',
            'templates.forum',

            'parameters.siteinfo',

            'pages',
            'categories',
            'categories.lov',
        ];
    }



    public static function keys () : array
    {
        Redis::select('1');

        $keys = Redis::keys('*');

        sort ($keys);

        return $keys;
    }
}