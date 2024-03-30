<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function AddRolePermission(){
       $roles =  Role::all();
       $permissions = Permission::all();
       $permission_groups = User::getPermissionGroups();
        return view("Backend.pages.rolesetup.add_role_permission", compact("roles","permissions","permission_groups"));
    }

    public function StoreRolePermission(Request $request){
        $data = array();
        $permissions = $request->permission;

        foreach($permissions as $key => $item){
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);

        } // end foreach 

        $notification = array(
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.role.permission')->with($notification);
    }

    public function AllRolePermission(){
        $roles = Role::all();
        return view("Backend.pages.rolesetup.all_role_permission", compact("roles"));

    }

    public function EditRolePermission($id){
        $roles = Role::findOrFail($id);
        $permissions = Permission::all();
        $permission_groups = User::getPermissionGroups();

        return view("Backend.pages.rolesetup.edit_role_permission", compact("roles","permissions","permission_groups"));

    }
}
