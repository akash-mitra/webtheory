<?php

namespace App\Http\Controllers;

use App\DataProvider;
use App\Jobs\CaptureViewEvent;
use App\Menu;
use App\Page;
use App\Parameter;
use App\User;
use DateTime;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display a landing page.
     *
     * @return Application|Factory|Response|View
     */
    public function root()
    {
        $homeMenuContent = $this->homeMenuItem();

        if ($homeMenuContent === null) {
            $data = DataProvider::home();
            return view('active.home', compact('data'));
        }

        switch ($homeMenuContent->menuable_type) {
            case 'App\\Page':
                return $this->single($homeMenuContent->menuable_id);
            default:
                return $this->category($homeMenuContent->menuable_id);
        }
    }

    /**
     * Display the single page view.
     *
     * @param string $pageId
     * @return Application|Factory|Response|View
     */
    public function single(string $pageId)
    {
        $data = DataProvider::single($pageId);

        CaptureViewEvent::dispatchAfterResponse($this->getAnalyticsData('App\Page', $pageId));

        return view('active.single', compact('data'));
    }

    /**
     * Display the single page view.
     *
     * @param string $categoryId
     * @return Application|Factory|Response|View
     */
    public function category(string $categoryId)
    {
        $data = DataProvider::category($categoryId);

        CaptureViewEvent::dispatchAfterResponse(
            $this->getAnalyticsData('App\Category', $categoryId)
        );

        return view('active.category', compact('data'));
    }

    /**
     * Display the user's profile view.
     *
     * @param string $publicProfileId
     * @return Application|Factory|View
     */
    public function profile(string $publicProfileId)
    {
        $user = User::findByPublicId($publicProfileId);
        $user->google2fa = isset($user->google2fa_secret) ? true : false;

        $data = DataProvider::profile(
            optional(auth()->user())->public_id === $publicProfileId
                ? $user
                : $user->only([
                'id',
                'name',
                'about_me',
                'url',
                'avatar',
                'public_id',
                'created_ago',
                'role',
                'email_verified_at',
            ])
        );

        CaptureViewEvent::dispatchAfterResponse($this->getAnalyticsData('App\User', $user->id));

        return view('active.profile', compact('data'));
    }

    /**
     * Display the sitemap.
     *
     * @return Response
     */
    public function sitemap(): Response
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $content .= '<url><loc>' . config('app.url') . '</loc></url>';
        $pages = Page::published()
            ->latest()
            ->get();
        foreach ($pages as $page) {
            $content .=
                '<url><loc>' .
                $page->url .
                '</loc><lastmod>' .
                $page->updated_at->format('Y-m-d') .
                '</lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>';
        }

        foreach ($this->custom_pages() as $page) {
            $content .=
                '<url><loc>' .
                $page['url'] .
                '</loc><lastmod>' .
                $page['updated_at']->format('Y-m-d') .
                '</lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>';
        }

        $content .= '</urlset>';

        return response($content, '200')->header('Content-Type', 'text/xml');
    }

    /**
     * Generates response containing the rss feed.
     *
     * @return Response
     */
    public function rss(): Response
    {
        $siteinfo = json_decode(Parameter::getKey('siteinfo'), true);
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<rss version="2.0">';
        $content .= '<channel>';
        $content .= '<title>' . $siteinfo['title'] . '</title>';
        $content .= '<link>' . config('app.url') . '</link>';
        $content .= '<description>' . $siteinfo['desc'] . '</description>';

        $pages = Page::with('author', 'category')
            ->published()
            ->latest()
            ->get();

        foreach ($pages as $page) {
            $content .=
                '<item><title>' .
                $page->title .
                '</title><link>' .
                $page->url .
                '</link><description>' .
                $page->metadesc .
                '</description><author>' .
                $page->author->email .
                '</author><pubDate>' .
                $page->created_at->tz('UTC')->toAtomString() .
                '</pubDate><category>' .
                $page->category->name .
                '</category></item>';
        }

        $content .= '</channel>';
        $content .= '</rss>';

        return response($content, '200')->header('Content-Type', 'text/xml');
    }

    public function privacy()
    {
        $data = DataProvider::home();

        if (view()->exists('active.privacy')) {
            return view('active.privacy', compact('data'));
        }

        return view('privacy', compact('data'));
    }

    public function terms()
    {
        $data = DataProvider::home();

        if (view()->exists('active.terms')) {
            return view('active.terms', compact('data'));
        }

        return view('terms', compact('data'));
    }

    /**
     * Attempt to load a blade file directly from the active template.
     * If the file is not present, throw 404 error.
     *
     * @param $any
     * @return Application|Factory|View
     */
    public function catchAll($any)
    {
        $bladeFileName = 'active.' . str_replace('/', '.', htmlentities($any));

        if (view()->exists($bladeFileName)) {
            $data = DataProvider::custom();

            return view($bladeFileName, compact('data'));
        }

        abort(404, 'This page does not exist');
    }

    private function homeMenuItem()
    {
        return Cache::rememberForever('home-menu', function () {
            return Menu::home()->first();
        });
    }

    private function getAnalyticsData($content_type, $content_id): array
    {
        $id = optional(request()->user())->id;
        $viewed_at = new DateTime("@$_SERVER[REQUEST_TIME]");

        return [
            // Public IP address of localhost for testing
            // 'ip' => file_get_contents('https://api.ipify.org'),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_id' => $id,
            'at' => $viewed_at,
            'date_key' => $viewed_at->format('Ymd'),
            'url' => $_SERVER['REQUEST_URI'],
            'content_type' => $content_type,
            'content_id' => $content_id,
            'agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
            'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
            'referrer_domain' => isset($_SERVER['HTTP_REFERER'])
                ? str_ireplace('www.', '', parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))
                : null,
            'session_id' => session()->getId(),
        ];
    }

    private function custom_pages(): array
    {
        $preloadedTemplateFiles = [
            'master.blade.php',

            'home.blade.php',
            'single.blade.php',
            'category.blade.php',
            'profile.blade.php',

            'login-modal.blade.php',
            'user-menu.blade.php',
            'blog.blade.php',
        ];

        $errorTemplateFiles = [
            '401.blade.php',
            '403.blade.php',
            '404.blade.php',
            '419.blade.php',
            '429.blade.php',
            '500.blade.php',
            '503.blade.php',
        ];

        $activeTemplateFiles = preg_grep(
            '/\b(\.blade.php)\b/',
            Storage::disk('active')->files('/')
        );
        $activeTemplateFiles = collect($activeTemplateFiles)
            ->flatten()
            ->toArray();

        $customFiles = array_diff(
            $activeTemplateFiles,
            $preloadedTemplateFiles,
            $errorTemplateFiles
        );
        $customFiles = collect($customFiles)
            ->flatten()
            ->toArray();

        $customPages = [];
        foreach ($customFiles as $file) {
            $content = Storage::disk('active')->get($file);

            if (
                (strpos($content, '<!doctype html>') !== false &&
                    !strpos($content, '@yield') !== false) ||
                strpos($content, '@extends') !== false
            ) {
                $lastModifiedUnix = Storage::disk('active')->lastModified($file);
                $lastModified = new DateTime("@$lastModifiedUnix");
                array_push($customPages, [
                    'url' => url('/') . '/' . str_replace('.blade.php', '', $file),
                    'updated_at' => $lastModified,
                ]);
            }
        }

        return $customPages;
    }
}
