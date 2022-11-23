<?php

namespace Delgont\Cms\Http\Middleware\Permission;

use Closure;
use Delgont\Cms\Models\Role\Role;


class PermissionViaRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role_key, $permission_key, $guard = null)
    {
        $user_roles = auth()->user()->roles;
        $roles = [];
        $permissions = [];

        if (count($user_roles)) {
            foreach ($user_roles as $role) {
                array_push($roles, $role->role);
            }
            if (in_array($role_key, $roles)) {
                $role_permissions = Role::where('role', 'writer')->first()->permissions;

                if (count($role_permissions)) {
                    foreach ($role_permissions as $permission) {
                        array_push($permissions, $permission->permission);
                    }
                    if (in_array($permission_key, $permissions)) {
                        //role has permission
                        return $next($request);
                    }else{
                        //role has no permission
                        abort(403, 'Role '.$role.' does not have permission');
                    }
                }else{
                    //no permissions assigned to this role
                    abort(403, $role_key.'s are forbidden from accessing this resource, Please contact your administrator');
                }
            }else{
                //user has no such role
                abort(403, 'Sorry, You do not have permission to access this resource, Only '.$role_key.'s');
            }
        }else{
            //no roles
            abort(403, 'Sorry you are not a '.$role_key);
        }

       return $next($request);
    }
}
