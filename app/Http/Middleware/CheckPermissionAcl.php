<?php

namespace App\Http\Middleware;

use App\Permission;
use Closure;
use Illuminate\Support\Facades\DB;

class CheckPermissionAcl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        // Lay tat ca quyen khi user login vao he thong
        // 1. Lay tat ca cac role cua user login he thong
        $listRoleOfUser = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('users.id', auth()->id())
            ->select('roles.*')
            ->get()->pluck('id')->toArray();
        //dd($listRoleOfUser);

        // 2.Lay tat ca cac quyen khi user login vao he thong
        $listRoleOfUser = DB::table('roles')
            ->join('role_permission', 'roles.id', '=', 'role_permission.role_id')
            ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
            ->where('roles.id', $listRoleOfUser)
            ->select('permissions.*')
            ->get()->pluck('id')->unique();

        // Lay tat ca quyen khi user vao he thong

        // Lay ra ma id man hinh tuong ung de check phan quyen
        $checkPermission = Permission::where('name', $permission)->value('id');


        // kiem tra user duoc phep vao man hinh nay khong?
        if ($listRoleOfUser->contains($checkPermission))
        {
            return $next($request);
        }

        return abort(401);
    }
}
