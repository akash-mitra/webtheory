<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $role = Auth::guest() ? 'guest' : Auth::user()->role;

        $routeName = explode('.', Route::currentRouteName());

        if ($this->checkAcl($routeName[0], $routeName[1], $role)) {
            return $next($request);
        }

//        if ($request->expectsJson()) {
//            return response([
//                "message" => "Restricted Access"
//            ], 403);
//        } else {
//            return redirect("/");
//        }

        abort(403, "Restricted Access");
    }

    /**
     * Check if access is allowed for a given resource and user role.
     *
     * @param $resource
     * @param $action
     * @param $role
     * @return mixed
     */
    private function checkAcl($resource, $action, $role)
    {
        $permissionArray = Cache::rememberForever('permissions', function () {

            /*
             * Convert the permission table to an array containing only the
             * relevant columns so that the cache size is reduced and
             * array lookup is faster.
             */
            return DB::table('permissions')
                ->select('resource', 'action', 'role')
                ->where('permission', "=", 1)
                ->get()
                ->map(function ($item) {
                    return $this->keyFormat($item->resource, $item->action, $item->role);
                })
                ->toArray();
        });

        return in_array($this->keyFormat($resource, $action, $role), $permissionArray);
    }

    private function keyFormat($resource, $action, $role): string
    {
        return $resource . $action . $role;
    }
}
