<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\WorkforceDecipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class WorkForceDisciplineController extends Controller
{
  public function __construct(workforceDecipline $workforceDecipline)
  {
    $this->workforceDecipline = $workforceDecipline;
  }


  public function FetchWorkForceDiscipline(Request $request){
    if($request->searchText){
        $workforceDecipline = WorkforceDecipline::with('fetchworkforceDisciplineForSearch');
        if ($request->searchColum == 'id'){
           $workforceDecipline->where('workforce_decipline.'.$request->searchColum,$request->searchText);
         }else{
           $workforceDecipline->where('workforce_decipline.'.$request->searchColum,'LIKE','%'.$request->searchText.'%');
         }
         $result = $workforceDecipline->paginate(config('paginateRecord'));
        // ->where($request->searchColum,'LIKE','%'.$request->searchText.'%')
        // ->paginate(config('paginateRecord'));
        // $workforceDecipline = $this->workforceDecipline->fetchworkforceDisciplineForSearch($request->searchColum,$request->searchText);
        return response()->json($result);
    }
    if($request->page && !$request->data_sort_order){
        $workforceDecipline=WorkforceDecipline::with('fetchworkforceDisciplineByPage')->paginate(config('paginateRecord'));
        // $workforceDecipline = $this->workforceDecipline->fetchworkforceDisciplineByPage();
        return response()->json($workforceDecipline);
    }
    else if($request->data_sort_order){
        $workforceDecipline=WorkforceDecipline::with('fetchworkforceDisciplineBySorting')->orderBy($request->sorted_colum,$request->data_sort_order)->paginate(config('paginateRecord'));
        //$workforceDecipline = $this->workforceDecipline->fetchworkforceDisciplineBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($workforceDecipline);
    }else if($request->parent){
         $workforceDecipline=WorkforceDecipline::where('parent_id',0)->orwhere('parent_id',null)->get();
          // $workforceDecipline = $this->workforceDecipline->fetchworkforceDisciplineParent($request->parent);
          return response()->json($workforceDecipline);
    }
    // $workforceDecipline = $this->workforceDecipline->fetchworkforceDiscipline();
    $workforceDecipline = WorkforceDecipline::with('fetchworkforceDiscipline')->get();
    return response()->json($workforceDecipline);
  }

  public function ActiveFetchWorkForceDiscipline(){
    $workforceDecipline = WorkforceDecipline::with('ActivefetchworkforceDisciplineParent')->where('workforce_decipline.'.'is_active',1)->get();
    return response()->json($workforceDecipline);
  }
  public function add_WorkForceDiscipline(Request $request){

      $rules = [
          // 'name' => 'required|regex:/^[a-zA-Z,\]+$/u',
          'name' => 'required|regex:/^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/',
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails()){
          $add_workforceDiscipline = [
              'status' => false,
              'success' => 0,
              'message' => $validator->errors()
          ];
          return response()->json($add_workforceDiscipline);
      }
      $data = $request->all();

      if($addworkforceDiscipline = WorkforceDecipline::create($data)){
          $add_workforceDiscipline = [
              'data' => $addworkforceDiscipline,
              'status' => true,
              'success' => 1,
              'message' => 'Work Force Discipline added successfully'
          ];
      }else{
          $add_workforceDiscipline = [
              'status' => false,
              'success' => 0,
              'message' => 'Something probelm in internal system'
          ];

      }
      return response()->json($add_workforceDiscipline);
  }

  public function getworkforceDiscipline($id){
        // $uid=$request->id;
        // $get=WorkforceDecipline::find($id);
        $get = WorkforceDecipline::with('getrecord')->find($id);
        if($get){
          $show_workforce_Discipline=[
            'data' => $get,
            'message' => 'Workforce Discipline Detail',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
          $show_workforce_Discipline=[
            'message' => 'Something probelm in internal system',
            'success' => '0',
            'status' => 'false'
          ];
        }
        return response()->json($show_workforce_Discipline);
     }

     public function deleteWorkForceDiscipline($id){
           // $uid=$request->id;
           $get=WorkforceDecipline::find($id);
           if($get){
               $del=WorkforceDecipline::find($id)->delete();
               $delete_workforce_discipline=[
                 'message' => 'Work Force Discipline Has Been Delete Successfully',
                 'success' => '1',
                 'status' => 'true'
               ];
           }else{
             $delete_workforce_discipline=[
               'message' => 'Something probelm in internal system',
               'success' => '0',
               'status' => 'false'
             ];
           }
           return response()->json($delete_workforce_discipline);
        }

        public function WorkForceDisciplineUpdate(Request $request){
          $rules = [
              'id' => 'required',
                'name' => 'required|regex:/^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/',
          ];
          $validator = Validator::make($request->all(),$rules);
          if($validator->fails()){
              $edit_Discipline = [
                  'status' => 'false',
                  'success' => '0',
                  'message' => $validator->errors()
              ];
              return response()->json($edit_Discipline);
          }

          $data = $request->all();
          $workforceDiscipline  = WorkforceDecipline::find($request->id);
          if($workforceDiscipline){
            if($workforceDiscipline->update($data)){
              $edit_workforceDiscipline=[
                'message' => 'Work Force Discipline Has Been Successfully Updated',
                'success' => '1',
                'status' => 'true'
              ];
            }
          }else{
            $edit_workforceDiscipline=[
              'message' => 'Something probelm in internal system',
              'success' => '0',
              'status' => 'false'
            ];
          }
             return response()->json($edit_workforceDiscipline);
          }
}
