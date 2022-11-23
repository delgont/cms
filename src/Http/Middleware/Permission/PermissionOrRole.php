<?php

namespace Delgont\Cms\Http\Middleware\Permission;

use Closure;
use Delgont\Cms\Exceptions\UnauthorizedException;



class PermissionOrRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission_key = null, $role_key = null, $guard = null)
    {
        if($permission_key){
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
        }
        if ($role_key) {
            $user_roles = auth()->user()->roles;
            if (count($user_roles)) {
                $roles = [];
                foreach ($user_roles as $role) {
                    array_push($roles, $role->role);
                }
                if (in_array($role_key, $roles)) {
                    return $next($request);
                }
            }else{
                //no roles
                abort(403, 'You must be a '.$role_key.' or have permission '.$permission_key);
            }
        }

        abort(403, 'Your dont have role or permission to access this resource');
    }
}
