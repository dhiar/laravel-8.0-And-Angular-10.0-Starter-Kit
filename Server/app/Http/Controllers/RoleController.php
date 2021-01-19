<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Country;
use DB;

class RoleController extends Controller
{
    public function __construct(Role $role, Country $country)
    {
      $this->role = $role;
      $this->country = $country;
    }

    public function fetchRoles(Request $request) {
        if($request->searchText){
            $roles = $this->role->fetchRolesForSearch($request->searchColum,$request->searchText);
            return response()->json($roles);
        }
        if($request->page && !$request->data_sort_order){
            $roles = $this->role->fetchRolesByPage();
            return response()->json($roles);
        }
        else if($request->data_sort_order){
            $roles = $this->role->fetchRolesBySorting($request->sorted_colum,$request->data_sort_order);
            return response()->json($roles);
        }
        $roles = $this->role->fetchRoles();
        return response()->json($roles);

    }

    public function getRoleById(Request $request, $id) {
       $role =  $this->role->getRoleById($id);
       return response()->json($role);
    }

     public function fetchRolesByCountry(Request $request, $id) {
        $roles =  $this->role->fetchRolesByCountry($id);
        return response()->json($roles);
    }

    public function addRole(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }

       $id = $this->role->insertGetId($request);
       $roles = $this->role->fetchRoles();

       return response()->json($roles);
    }

    public function updateRole(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }

        $this->role->UpdateRecord($request);
        $roles = $this->role->fetchRolesByPage();
        return response()->json($roles);
    }

    public function deleteRole(Request $request, $id) {
         $this->role->DeleteRole($id);
         return response()->json('Successfully Deleted', 200);
     }

}
