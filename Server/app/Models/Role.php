<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    public function fetchRolesForSearch($searchColum, $searchText) {
         $roles =   DB::table('roles')
                      ->where('roles.'. $searchColum,'LIKE','%'.$searchText.'%')
                      ->select(
                        'roles.*'
                        )
                      ->paginate(config('paginateRecord'));
         return $roles;
    }

    public function fetchRolesByPage() {
        $roles = DB::table('roles')
                    ->select(
                      'roles.*'
                      )
                    ->paginate(config('paginateRecord'));
        return $roles;
    }

    public function fetchRolesBySorting($sorted_colum, $data_sort_order) {
        $roles = DB::table('roles')
                       ->where('roles.is_active', 1)
                       ->select(
                         'roles.*'
                         )
                       ->orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $roles;
    }

    public function fetchRoles() {
        $roles = DB::table('roles')
                        ->where('roles.is_active', 1)
                        ->select(
                          'roles.*'
                          )
                          ->where('is_active',1)
                        ->get();
        return $roles;
    }

     public function fetchRolesByCountry($id) {
        $roles = DB::table('roles')
                        ->where('country_id',$id)
                        ->select(
                          'roles.*'
                          )
                        ->get();
        return $roles;
    }

    public function getRoleById($id) {
          $role = DB::table('roles')
                    ->where('roles.id',$id)
                    ->select(
                      'roles.*'
                      )
                    ->first();
        return $role;
    }

    public function insertGetId($request) {


        $id = DB::table('roles')
                ->insertGetId([
                    'name' => $request->name,
                    'is_active' => $request->is_active,
                ]);
        return $id;
    }

    public function UpdateRecord($request) {
        DB::table('roles')
        ->where('id',$request->id)
          ->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'updated_at' => now()
          ]);
        return 'success';
    }

    public function DeleteRole($id) {
        DB::table('roles')->where('id', $id)->delete();
        return 'success';
    }

}
