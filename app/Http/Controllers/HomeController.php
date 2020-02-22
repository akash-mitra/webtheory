<?php

namespace App\Http\Controllers;


use App\DataProvider;
use Illuminate\Http\Request;


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
        // return (array)$data;
        return view('templates.single', compact('data'));
    }


}
