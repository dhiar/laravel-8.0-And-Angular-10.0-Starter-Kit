<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\WorkforceNature;
use Illuminate\Http\Request;

use App\Models\Discipline;
use Illuminate\Support\Facades\Validator;

class DisciplineController extends Controller
{
    protected $Discipline;
    public function __construct(Discipline $Discipline)
    {
        $this->Discipline = $Discipline;
    }
    public function getAllDiscipline(Request $request){
      if($request->searchText){
          $Discipline = $this->Discipline->fetchDisciplineForSearch($request->searchColum,$request->searchText);
          return response()->json($Discipline);
      }
      if($request->page && !$request->data_sort_order){
          $Discipline = $this->Discipline->fetchDisciplineByPage();
          return response()->json($Discipline);
      }
      else if($request->data_sort_order){
          $Discipline = $this->Discipline->fetchDisciplineBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($Discipline);
      }
      $Discipline = $this->Discipline->fetchDiscipline();
      return response()->json($Discipline);
    }

    public function disciplineStore(Request $request){

        $rules = [
            'name'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }

        $data = $request->all();
        $data['is_active'] = 1;
        $data['status'] = 1;

        if($discipline = Discipline::create($data)){
            $response = [
                'data' => $discipline,
                'status' => true,
                'success' => 1,
                'message' => 'Discipline added successfully'
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

    public function getDisciplineById($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }
        $discipline = Discipline::find($id);
        if(!is_null($discipline)){
            $response = [
                'data' => $discipline,
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

    public function disciplineUpdate(Request $request){
        $rules = [
            'id' => 'required',
            'name'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }

        $data = $request->all();
        $data['is_active'] = 1;
        $data['status'] = 1;

        $discipline = Discipline::find($request->id);
        if($discipline->update($data)){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Discipline updated successfully'
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

    public function deleteDiscipline($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }

        $discipline = Discipline::find($id);

        if($discipline->delete()){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Discipline deleted successfully'
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
