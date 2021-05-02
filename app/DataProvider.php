<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\ViewContent;
use App\Category;
use App\Page;
use App\Form;

class DataProvider
{
    /**
     * Returns a data object containing following keys: ref, pages, categories, menus, user
     * @return object
     */
    public static function home(): object
    {
        return (object)[
            'ref' => self::ref('home'),
            'pages' => self::pages(),
            'categories' => self::categories(),
            'menus' => self::menus(),
            'user' => auth()->user(),
        ];
    }

    /**
     * Returns a data object containing following keys: ref, page, categories, menus, user
     * @param $id Mixed Id of the requested page
     * @return object
     */
    public static function single($id): object
    {
        $page = Page::with([
            'contents' => function ($q) {
                $q->orderBy('display_order')->select(['body_html', 'page_id', 'display_order']);
            },
            'author',
            'category',
        ])
            ->published()
            ->findOrFail($id);

        return (object)[
            'ref' => self::ref('single'),
            'page' => $page,
            'categories' => self::categories(),
            'menus' => self::menus(),
            'user' => auth()->user(),
            'top_pages' => ViewContent::monthly(),
            'recent_pages' => Page::where('status', 'Live')->latest()->paginate(5),
            'author_pages' => Page::where([['user_id', $page->user_id], ['status', 'Live']])->latest()->paginate(5),
        ];
    }

    /**
     * Returns a data object containing following keys: ref, category, menus, user
     * @param $id Mixed Id of the requested category
     * @return object
     */
    public static function category($id): object
    {
        $category = Category::with([
            'author',
            'subcategories',
            'pages' => function ($q) {
                $q->published();
            },
            'parent',
        ])->findOrFail($id);

        return (object)[
            'ref' => self::ref('category'),
            'category' => $category,
            'menus' => self::menus(),
            'user' => auth()->user(),
        ];
    }

    public static function profile($user): object
    {
        return (object)[
            'ref' => self::ref('profile'),
            'profile' => (object)$user,
            'menus' => self::menus(),
            'user' => auth()->user(),
        ];
    }

    public static function form($id): object
    {
        $form = Form::where('status', 'Live')->findOrFail($id);

        return (object)[
            'ref' => self::ref('form'),
            'form' => $form,
            'menus' => self::menus(),
            'user' => auth()->user(),
        ];
    }

    public static function custom(): object
    {
        return (object)[
            'ref' => self::ref('custom'),
            'pages' => self::pages(),
            'categories' => self::categories(),
            'menus' => self::menus(),
            'user' => auth()->user(),
        ];
    }

    private static function categories()
    {
        return Cache::rememberForever('categories', function () {
            return Category::with('author')->get();
        });
    }

    private static function pages($howMany = 15)
    {
        /*
         * Only cache if request does not have any pagination parameter.
         *
         * Alternatively, we could create different cache keys for
         * different pages of the pagination. But that approach
         * will open the door to cache flooding attack by
         * continuously sending different values for the
         * pagination parameters from the web. Another
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

    private static function ref(string $contentType): object
    {
        return (object)[
            'contentType' => $contentType,
            'template' => self::template(),
            'site' => self::site(),
            'share' => self::share(),
            'login' => (object)[
                'socialprovider' => json_decode(Parameter::getKey('socialprovider'), false),
            ],
        ];
    }

    /*
     * Returns the template parameters pertaining
     * to the active template of the given type.
     */
    private static function template(): object
    {
        return Cache::rememberForever('template.parameters', function () {
            $param = optional(Template::where('active', 1)->first())->parameters;

            $array = (array)json_decode($param, true);

            return (object)array_column($array, 'value', 'name');
        });
    }

    public static function site(): object
    {
        return (object)json_decode(Parameter::getKey('siteinfo'));
    }

    private static function share(): object
    {
        return (object)json_decode(Parameter::getKey('share'));
    }


    public static function keys(): array
    {
        Redis::select('1');

        $keys = Redis::keys('*');

        sort($keys);

        return $keys;
    }

    private static function menus()
    {
        return Cache::rememberForever('menus', function () {
            return Menu::orderBy('sequence_num')->get();
        });
    }
}
