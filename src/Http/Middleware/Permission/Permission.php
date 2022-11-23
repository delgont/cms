<?php

namespace Delgont\Cms\Http\Middleware\Permission;

use Closure;
use Delgont\Cms\Exceptions\UnauthorizedException;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission_key, $guard = null)
    {
        $authenticated = app('auth')->guard($guard);

        if ($authenticated->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $user_permissions = auth($guard)->user()->permissions; //in the next version cache the user permissions so as to check if it does exit in cache first
        $permissions = [];
        if(count($user_permissions)){
            foreach ($user_permissions as $permission) {
                array_push($permissions, $permission->permission);
            }
            if(in_array($permission_key, $permissions)){
                return $next($request);
            }
        }else{
            throw UnauthorizedException::userHasNoPermission($permission_key);
        }
        
        throw UnauthorizedException::userHasNoPermission($permission_key);
    }
}
