<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function AllRole(){
        $roles = Role::all();

        return view("Backend.pages.roles.all_roles", compact("roles"));
    }

    public function AddRole(){
        return view("Backend.pages.roles.add_role");
    }

    public function StoreRole(Request $request){
        Role::create([
            'name' => $request->name,

        ]);

        $notification = array(
            'message' => 'Role created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }

    public function EditRole($id){
        $role = Role::findOrFail($id);

        return view("Backend.pages.roles.edit_role", compact("role"));

    }

    public function UpdateRole(Request $request){
        $id = $request->id;
        Role::find($id)->update([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }

    public function DeleteRole($id){
        Role::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Role deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);

    }
}
