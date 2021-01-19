<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Permission extends Model
{

    public function fetchPermissionsByRole($id) {
        $permissions = DB::table('permissions')->get();
        $role_permissions = DB::table('role_permissions')->where('role_id',$id)->get();
        foreach ($permissions as $key => $permission) {
          $check = DB::table('role_permissions')->where('role_id',$id)->where('permission_id',$permission->id)->first();
          if($check){
            $permission->checked = true;
          }
          else{
            $permission->checked = false;

          }
        }
        return $permissions;
    }
    public function updatePermission($request) {
      $data = $request->all();
       DB::table('role_permissions')->where('role_id',$data["role_id"])->delete();
       foreach ($data["permissions_ids"] as $key => $new_permission) {
              DB::table('role_permissions')
                ->insert([
                  'role_id' => $data["role_id"],
                  'permission_id' => $new_permission["id"]
                ]);
       }
    }

}
