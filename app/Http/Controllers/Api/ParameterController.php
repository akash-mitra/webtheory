<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Parameter;

class ParameterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission']);
    }

    /**
     * Get the specified key's value.
     *
     * @param  String  $key
     * @return \Illuminate\Http\Response
     */
    public function get(String $key)
    {
        $value = Parameter::getKey($key);
        return response()->json($value);
    }

    /**
     * Save a key-value pair.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function set(String $key, Request $request)
    {
        $value = Parameter::setKey($key, $request->value);
        return response()->json($value);
    }
}
