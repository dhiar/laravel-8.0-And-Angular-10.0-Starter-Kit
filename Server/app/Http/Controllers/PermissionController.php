<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Permission;
use DB;

class PermissionController extends Controller
{
    public function __construct(Permission $permission)
    {
      $this->permission = $permission;
    }
     public function fetchPermissionsByRole(Request $request, $id) {
        $roles =  $this->permission->fetchPermissionsByRole($id);
        return response()->json($roles);
    }
    public function fetchPermissions(Request $request, $id) {
       $allpermissions = DB::table('permissions')->get();
       foreach ($allpermissions as $key => $permission) {
         $check = DB::table('role_permissions')->where('role_id',$id)->where('permission_id',$permission->id)->first();
         if($check){
           $permission->checked = true;
         }
         else{
           $permission->checked = false;

         }
       }
       return response()->json($allpermissions);
   }

    public function updatePermission(Request $request) {
       $roles =  $this->permission->updatePermission($request);
       return response()->json('success');
   }


}
