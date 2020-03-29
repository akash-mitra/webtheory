<?php

namespace App\Http\Controllers;


use App\DataProvider;
use Illuminate\Http\Request;
use App\Page;
use App\Jobs\CaptureViewEvent;
use App\Parameter;

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

        return view('templates.home', compact('data'));
    }



    /**
     * Display the single page view.
     *
     * @return \Illuminate\Http\Response
     */
    public function single($page)
    {
        $data = DataProvider::single($page);
        
        CaptureViewEvent::dispatchAfterResponse($this->capture_analytics('App\Page', $page));

        return view('templates.single', compact('data'));
    }



    /**
     * Display the single page view.
     *
     * @return \Illuminate\Http\Response
     */
    public function category($category)
    {

        $data = DataProvider::category($category);

        CaptureViewEvent::dispatchAfterResponse($this->capture_analytics('App\Category', $category));

        return view('templates.category', compact('data'));
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
        $pages = Page::published()->latest()->get();
        foreach ($pages as $page)
            $content .= '<url><loc>' . $page->url . '</loc><lastmod>' . $page->updated_at->tz('UTC')->toAtomString() . '</lastmod></url>';

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

        $pages = Page::with('author', 'category')->published()->latest()->get();
        foreach ($pages as $page)
            $content .= '<item><title>' . $page->title . '</title><link>' . $page->url . '</link><description>' . $page->metadesc . '<description><author>' . $page->author->email . '</author><pubDate>' . $page->created_at->tz('UTC')->toAtomString() . '</pubDate><category>' . $page->category->name . '</category></item>';

        $content .= '</channel>';
        $content .= '</rss>';

        return response($content, '200')->header('Content-Type', 'text/xml');
    }

    private function capture_analytics ($content_type, $content_id)
    {
        $id = optional(request()->user())->id;
        
        return [
            'ip' => $_SERVER["REMOTE_ADDR"],
            'user_id' => $id,
            'at' => $_SERVER["REQUEST_TIME_FLOAT"],
            'url' => $_SERVER["REQUEST_URI"],
            'content_type' => $content_type,
            'content_id' => $content_id,
            'agent' => $_SERVER["HTTP_USER_AGENT"],
            'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
        ];
    }
}
