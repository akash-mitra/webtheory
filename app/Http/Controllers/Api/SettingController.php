<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Parameter;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['check.permission']);
    }

    public function loginprovider(Request $request)
    {
        $data = $request->data;
        foreach($data as $lov) {
            $key = $lov['key'];
            $value = is_null($lov['value']) ? '' : $lov['value'];
            Parameter::setKey($key, $value);    
        }
        
        return response()->json("Saved", 200);
    }


}