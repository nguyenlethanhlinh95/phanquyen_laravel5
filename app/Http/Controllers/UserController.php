<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;

use Mockery\Exception;

class UserController extends Controller
{
    //
    private $user, $role;
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index()
    {
        $listUser = $this->user->all();
        return view('user.index', compact('listUser'));
    }

    public function create()
    {
        $roles = $this->role->all();
        return view('user.add', compact('roles'));
    }

    public function store(Request $request)
    {
        //required input
        DB::beginTransaction();
        try{
            // Insert data to user table
            $userCreate = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            // Insert data to role_user

            // co the chen theo cach nay
            $userCreate->roles()->attach($request->roles);
//            $roles = $request->roles;
//            if(is_array($roles)){
//                foreach ($roles as $roleId)
//                {
//                    DB::table('role_user')->insert([
//                        'user_id' => $userCreate->id,
//                        'role_id' => $roleId
//                    ]);
//                }
//            }
            DB::commit();
            return redirect()->route('user.index')->with('succ', 'Thêm mới thành công !');
        }catch (\Exception $exception){
            DB::rollback();
        }


    }

    /*
     * show form edit
     *
    */
    public function edit($id)
    {
        $roles = $this->role->all(); // lay ra tat ca quyen
        $user = $this->user->findOrfail($id); // lay thong tin user
        $listRoleOfUser = DB::table('role_user')->where('user_id', $id)->get(); // lay danh sach quyen
//        echo '<pre>';
//        print_r($listRoleOfUser);
//        echo '</pre>';
        return view('user.edit', compact('roles', 'user', 'listRoleOfUser'));
    }

    public function update(Request $request, $id)
    {
        //required input
        DB::beginTransaction();
        try{
            // update user table
            $this->user->where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            // Update to role_user table
            DB::table('role_user')->where('user_id', $id)->delete();

            $roles = $request->roles;
            if(is_array($roles)){
                foreach ($roles as $roleId)
                {
                    DB::table('role_user')->insert([
                        'user_id' => $id,
                        'role_id' => $roleId
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('user.index');

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
            DB::table('users')->delete($id);

            //delete user of role_user table
            DB::table('role_user')->where('user_id', '=', $id)->delete();

            DB::commit();
            return redirect()->route('user.index');
        }
        catch (\Exception $exception){
            DB::rollback();
        }
    }
}
