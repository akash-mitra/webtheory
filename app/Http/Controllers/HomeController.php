<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;
use App\Parameter;
use App\DataProvider;
use App\Jobs\CaptureViewEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display a landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function root()
    {
        $data = DataProvider::home();

        return view('active.home', compact('data'));
    }

    /**
     * Display a blog page.
     *
     * @return \Illuminate\Http\Response
     */
    public function blog()
    {
        $data = DataProvider::home();

        return view('active.blog', compact('data'));
    }

    /**
     * Display the single page view.
     *
     * @return \Illuminate\Http\Response
     */
    public function single($page)
    {
        $data = DataProvider::single($page);

        CaptureViewEvent::dispatchAfterResponse(
            $this->capture_analytics('App\Page', $page)
        );

        return view('active.single', compact('data'));
    }

    /**
     * Display the single page view.
     *
     * @return \Illuminate\Http\Response
     */
    public function category($category)
    {
        $data = DataProvider::category($category);

        CaptureViewEvent::dispatchAfterResponse(
            $this->capture_analytics('App\Category', $category)
        );

        return view('active.category', compact('data'));
    }

    public function profile($public_id)
    {
        $user = User::findByPublicId($public_id);

        $data = DataProvider::profile(
            auth()->user()->public_id === $public_id
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

        CaptureViewEvent::dispatchAfterResponse(
            $this->capture_analytics('App\User', $user->id)
        );

        return view('active.profile', compact('data'));
    }

    /**
     * Display the sitemap.
     *
     * @return \Illuminate\Http\Response
     */
    public function sitemap()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $content .= '<url><loc>' . env('APP_URL') . '</loc></url>';
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
     * Display the rss.
     *
     * @return \Illuminate\Http\Response
     */
    public function rss()
    {
        $siteinfo = json_decode(Parameter::getKey('siteinfo'), true);
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<rss version="2.0">';
        $content .= '<channel>';
        $content .= '<title>' . $siteinfo['title'] . '</title>';
        $content .= '<link>' . env('APP_URL') . '</link>';
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

    public function catchAll($any)
    {
        $bladeFileName = 'active.' . str_replace('/', '.', htmlentities($any));

        if (view()->exists($bladeFileName)) {
            $data = DataProvider::custom();

            return view($bladeFileName, compact('data'));
        }

        return abort(404, 'This page does not exist');
    }

    private function capture_analytics($content_type, $content_id)
    {
        $id = optional(request()->user())->id;

        return [
            // Public IP address of localhost for testing
            // 'ip' => file_get_contents('https://api.ipify.org'),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_id' => $id,
            'at' => $_SERVER['REQUEST_TIME_FLOAT'],
            'url' => $_SERVER['REQUEST_URI'],
            'content_type' => $content_type,
            'content_id' => $content_id,
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
            'referrer_domain' => isset($_SERVER['HTTP_REFERER']) ? str_ireplace('www.', '', parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)) : null,
            'session_id' => session()->getId(),
        ];
    }

    private function custom_pages()
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
                $lastModified = new \DateTime("@$lastModifiedUnix");
                array_push($customPages, [
                    'url' => url('/') . '/' . str_replace('.blade.php', '', $file),
                    'updated_at' => $lastModified,
                ]);
            }
        }

        return $customPages;
    }
}
