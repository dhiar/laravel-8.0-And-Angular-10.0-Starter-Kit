<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Contract_types;
use Validator;

class ContracttypeController extends Controller
{
  public function __construct(Contract_types $Contract_types)
  {
    $this->Contract_types = $Contract_types;
  }
    public function contractTypeList(Request $request){
      if($request->searchText){
          $Contract_types = $this->Contract_types->fetchcontactTypesForSearch($request->searchColum,$request->searchText);
          return response()->json($Contract_types);
      }
      if($request->page && !$request->data_sort_order){
          $Contract_types = $this->Contract_types->fetchcontactTypesByPage();
          return response()->json($Contract_types);
      }
      else if($request->data_sort_order){
          $Contract_types = $this->Contract_types->fetchcontactTypesBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($Contract_types);
      }
      $Contract_types = $this->Contract_types->fetchcontactTypes();
      return response()->json($Contract_types);
    }

    public function contractTypeStore(Request $request){
        $rules = [
            'name'=>'required|regex:/^[a-zA-Z]+$/u'
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

        if($contract_type = Contract_types::create($data)){
            $response = [
                'data' => $contract_type,
                'status' => true,
                'success' => 1,
                'message' => 'Contract type added successfully'
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

    public function contractTypeById($id=0){

        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }
        $contract_type = Contract_types::find($id);
        if(!is_null($contract_type)){
            $response = [
                'data' => $contract_type,
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

    public function contractTypeUpdate(Request $request){
        $rules = [
            'name'=>'required|regex:/^[a-zA-Z]+$/u'
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

        $contract_type = Contract_types::find($request->id);
        if($contract_type->update($data)){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Contract type updated successfully'
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

    public function deleteContractType($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }
        $contract_type = Contract_types::find($id);

        if($contract_type->delete()){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Contract type deleted successfully'
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
