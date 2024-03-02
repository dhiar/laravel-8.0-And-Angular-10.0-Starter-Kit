<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Workforce;

class LabourController extends Controller
{
  public function __construct(Workforce $Workforce)
  {
    $this->Workforce = $Workforce;
  }
    public function getAllLabour(Request $request){
      if($request->searchText){
          $Workforce = $this->Workforce->fetchWorkForceForSearch($request->searchColum,$request->searchText);
          return response()->json($Workforce);
      }
      if($request->page && !$request->data_sort_order){
          $Workforce = $this->Workforce->fetchWorkForceByPage();
          return response()->json($Workforce);
      }
      else if($request->data_sort_order){
          $Workforce = $this->Workforce->fetchWorkForceBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($Workforce);
      }
      $Workforce = $this->Workforce->fetchWorkForce();
      return response()->json($Workforce);
        // $workForce = Workforce::orderBy('id',$sort)->paginate($page);
        //
        // if($workForce){
        //
        //     if(count($workForce) > 0){
        //         $response = [
        //             'data' => $workForce,
        //             'status' => true,
        //             'success' => 1,
        //         ];
        //
        //     }else{
        //         $response = [
        //             'status' => false,
        //             'success' => 0,
        //             'message' => 'Record not found'
        //         ];
        //
        //     }
        //     return response()->json($response);
        //
        // }else{
        //
        //     $response = [
        //         'status' => false,
        //         'success' => 0,
        //         'message' => 'Something probelm in internal system'
        //     ];
        //     return response()->json($response);
        // }
        //

    }

    public function labourStore(Request $request){
        $rules = [
            'job_nature_id' => 'required',
            'work_role_id' => 'required',
            'discipline_id' => 'required',
            'zone_id' => 'required',
            'employee_name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:work_force',
            'agency' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }
        $data = $request->all();

        if($workForce = Workforce::create($data)){
            $response = [
                'data' => $workForce,
                'status' => true,
                'success' => 1,
                'message' => 'Work force added successfully'
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

    public function labourUpdate(Request $request){

        $rules = [
            'id'=>'required',
            'job_nature_id' => 'required',
            'work_role_id' => 'required',
            'discipline_id' => 'required',
            'zone_id' => 'required',
            'employee_name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:work_force',
            'agency' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }
        $data = $request->all();

        $workForce = Workforce::find($request->id);
        if($workForce->update($data)){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Work force updated successfully'
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

    public function getLabourById($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }

        $workForce = Workforce::find($id);
        if(!is_null($workForce)){
            $response = [
                'data' => $workForce,
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

    public function deleteLabour($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }

        $workForce = Workforce::find($id);
        if($workForce->delete()){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Work force deleted successfully'
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
