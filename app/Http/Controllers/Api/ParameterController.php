<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Parameter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param String $key
     * @return JsonResponse
     */
    public function get(string $key): JsonResponse
    {
        $value = Parameter::getKey($key);

        return response()->json($value);
    }

    /**
     * Save a key-value pair.
     *
     * @param string $key
     * @param Request $request
     * @return JsonResponse
     */
    public function set(string $key, Request $request): JsonResponse
    {
        $value = Parameter::setKey($key, $request->value);

        return response()->json($value);
    }
}
