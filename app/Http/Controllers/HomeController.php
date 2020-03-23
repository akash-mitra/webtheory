<?php

namespace App\Http\Controllers;


use App\DataProvider;
use Illuminate\Http\Request;
use App\Page;


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
}
