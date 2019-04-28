<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // list role
    private $role, $permission;
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $listRole = $this->role->all();
        return view('role.index', compact('listRole'));
    }

    /*
     * show form create role
     * */
    public function create()
    {
        // get all chi tiet quyen
        $permissions = $this->permission->all();
        return view('role.add', compact('permissions'));
    }

    /*
     * create post role
     * */
    public function store(Request $request)
    {
        //required input
        DB::beginTransaction();
        try{
            // Insert data to role table
            $roleCreate = $this->role->create([
                'name' => $request->name,
                'display_name' => $request->display_name
            ]);
            // Insert data to role_permission
            $roleCreate->permissons()->attach($request->permission);
            DB::commit();
            return redirect()->route('role.index')->with('succ', 'Thêm mới role thành công !');
        }catch (\Exception $exception){
            DB::rollback();
            \Log::error('Loi: ' . $exception->getMessage() .$exception->getLine() );
        }
    }


    public function edit($id)
    {
        $permissions = $this->permission->all();
        $role = $this->role->findOrfail($id);
        $getAllRolePermissions = DB::table('role_permission')->where('role_id', $id)->pluck('permission_id');


//        foreach ($getAllRolePermissions as $getAllRolePermission)
//        {
//            echo $getAllRolePermission;
//        }
        return view('role.edit', compact('permissions', 'role', 'getAllRolePermissions'));
    }

    public function update(Request $request, $id)
    {
        //required input
        DB::beginTransaction();
        try{
            // update user table
            $this->role->where('id', $id)->update([
                'name' => $request->name,
                'display_name' => $request->display_name
            ]);

            // Update to role_permission table
            DB::table('role_permission')->where('role_id', $id)->delete();

            $permissions = $request->permission;
//            echo '<pre>';
//            print_r($permissions);
//            echo '</pre>';
            if(is_array($permissions)){
                foreach ($permissions as $permission)
                {
                    DB::table('role_permission')->insert([
                        'permission_id' => $permission,
                        'role_id' => $id
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('role.index');

        }
        catch(\Exception $exception) {
            DB::rollback();
        };
    }


    // delete
    public function delete($id)
    {
        //required input
        DB::beginTransaction();
        try{
            // find user id
            DB::table('roles')->delete($id);

            //delete user of role_user table
            DB::table('role_permission')->where('role_id', '=', $id)->delete();

            DB::commit();
            return redirect()->route('role.index');
        }
        catch (\Exception $exception){
            DB::rollback();
        }
    }
}
