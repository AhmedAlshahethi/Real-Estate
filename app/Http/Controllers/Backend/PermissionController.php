<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;

class PermissionController extends Controller
{
    public function AllPermission(){
        $permissions = Permission::all();
        return view("Backend.pages.permissions.all_permissions", compact("permissions"));
    }


    public function AddPermission(){

        return view('Backend.pages.permissions.add_permission');
    }

    public function StorePermission(Request $request){
        $permission = Permission::create([
            'name'=> $request->name,
            'group_name' => $request->group_name,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Permission created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permissions')->with($notification);
    }

    public function EditPermission($id){
        $permission = Permission::findOrFail($id);

        return view('Backend.pages.permissions.edit_permission', compact('permission'));
    }

    public function UpdatePermission(Request $request){

         $id = $request->id;

         Permission::findOrFaIL($id)->update([
            'name'=> $request->name,
            'group_name' => $request->group_name,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Permission updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permissions')->with($notification);

    }   

    public function DeletePermission($id){

        Permission::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Permission deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permissions')->with($notification);
    }

    public function ImportPermission(){
        return view('Backend.pages.permissions.import_permission');
    }

    public function ExportPermission(){
     
        return Excel::download(new PermissionExport,'permissions.xlsx');
    }

    public function Import(Request $request){
        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->route('all.permissions')->with($notification);
    }

    
}
