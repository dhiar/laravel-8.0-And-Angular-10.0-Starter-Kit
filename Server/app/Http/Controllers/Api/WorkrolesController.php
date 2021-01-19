<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Contract_types;
use Illuminate\Http\Request;
use App\Models\WorkRoles;
use Validator;

class WorkrolesController extends Controller
{
  public function __construct(WorkRoles $WorkRoles)
  {
    $this->WorkRoles = $WorkRoles;
  }
    public function getAllWorkRoles(Request $request){
      if($request->searchText){
          $WorkRoles = $this->WorkRoles->fetchWorkRolesForSearch($request->searchColum,$request->searchText);
          return response()->json($WorkRoles);
      }
      if($request->page && !$request->data_sort_order){
          $WorkRoles = $this->WorkRoles->fetchWorkRolesByPage();
          return response()->json($WorkRoles);
      }
      else if($request->data_sort_order){
          $WorkRoles = $this->WorkRoles->fetchWorkRolesBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($WorkRoles);
      }
      $WorkRoles = $this->WorkRoles->fetchWorkRoles();
      return response()->json($WorkRoles);
    }

    public function workRoleStore(Request $request){
        $rules = [
            'name'=>'required|string',
        ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->messages()
            ];
            return response()->json($response);
        }

        $data = $request->all();
        $data['is_active'] = 1;
        $data['status'] = 1;

        if($workRoles = WorkRoles::create($data)){
            $response = [
                'data' => $workRoles,
                'status' => true,
                'success' => 1,
                'message' => 'Work role added successfully'
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
            return response()->json($response);
        }

    }

    public function getWorkRoleById($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }

        $workRoles = WorkRoles::find($id);
        if(!is_null($workRoles)){
            $response = [
                'data' => $workRoles,
                'status' => true,
                'success' => 1
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Record not found'
            ];
            return response()->json($response);
        }

    }

    public function workRoleUpdate(Request $request){
        $rules = [
            'id' => 'required|integer',
            'name'=>'required|regex:/^[a-zA-Z]+$/u',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->messages()
            ];
            return response()->json($response);
        }

        $data = $request->all();
        $data['is_active'] = 1;
        $data['status'] = 1;

        $workRole = WorkRoles::find($request->id);
        if($workRole->update($data)){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Work role updated successfully'
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
            return response()->json($response);
        }

    }

    public function deleteWorkRole($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }

        $workRole = WorkRoles::find($id);
        if($workRole->delete()){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Work role deleted successfully'
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
            return response()->json($response);
        }

    }
}
