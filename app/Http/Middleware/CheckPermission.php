<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use App\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class CheckPermission
{
    private $role;
    private $resource;
    private $action;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $method = explode('.', Route::currentRouteName());

        $this->resource = $method[0];
        $this->action = $method[1];
        $this->role = Auth::guest() ? 'guest' : Auth::user()->role;

        if ($this->checkAcl()) {
            return $next($request);
        }

        return abort(403, "Restricted Access");
    }

    /**
     * Check allow in AccessControlList.
     */
    private function checkAcl()
    {
        // return Permission::where('role', $this->role)->where('resource', $this->resource)->where('action', $this->action)->pluck('permission')->first();

        $acl = Cache::rememberForever('permissions', function () {
            return DB::table('permissions')->get();
        });

        return $acl->where('role', $this->role)->where('resource', $this->resource)->where('action', $this->action)->pluck('permission')->first();
    }
}
