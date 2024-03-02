<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\unit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UnitController extends Controller
{
  protected $unit;
  public function __construct(unit $unit)
  {
    $this->unit = $unit;
  }
  public function fetchUnit(Request $request){
    if($request->searchText){
        $unit = $this->unit->fetchUnitForSearch($request->searchColum,$request->searchText);
        return response()->json($unit);
    }
    if($request->page && !$request->data_sort_order){
        $unit = $this->unit->fetchUnitByPage();
        return response()->json($unit);
    }
    else if($request->data_sort_order){
        $unit = $this->unit->fetchUnitBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($unit);
    }
    $unit = $this->unit->fetchUnit();
    return response()->json($unit);
  }

public function activefetchUnit(){
  $unit = $this->unit->actvfetchUnit();
  return response()->json($unit);
}

  public function add_unit(Request $request){
    $rules=[
        'type' => 'required|regex:/^[a-zA-Z]+$/u',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $add_unit = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->errors()
        ];
        return response()->json($add_unit);
    }
        $check_this=unit::where('type',$request->type)->first();
        if($check_this){
          $add_unit=[
            'message' => 'Your Unit Is Already Exist',
            'success' => '0',
            'status' => 'false'
            ];
        }else{
        $addUnit=new unit();
        $addUnit->type=$request->type;
        $addUnit->save();
        if($addUnit->save()){
          $lastid=$addUnit->id;
          $get=unit::where('id',$lastid)->first();
          $add_unit=[
            'data' => $get,
            'message' => 'Add Unit successfully',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
        $add_unit=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
          ];
        }
      }
        return response()->json($add_unit);
     }

     public function show_unit($id){
           // $uid=$request->id;
           $get=unit::find($id);
           if($get){
             $show_unit=[
               'data' => $get,
               'message' => 'Unit Detail',
               'success' => '1',
               'status' => 'true'
             ];
           }else{
             $show_unit=[
               'message' => 'Something probelm in internal system',
               'success' => '0',
               'status' => 'false'
             ];
           }
           return response()->json($show_unit);
        }

        public function delete_unit($id){
              // $uid=$request->id;
              $get=unit::find($id);
              if($get){
                  $del=unit::find($id)->delete();
                  $delete_unit=[
                    'message' => 'Unit Has Been Delete Successfully',
                    'success' => '1',
                    'status' => 'true'
                  ];
              }else{
                $delete_unit=[
                  'message' => 'Something probelm in internal system',
                  'success' => '0',
                  'status' => 'false'
                ];
              }
              return response()->json($delete_unit);
           }

           public function edit_unit(Request $request){
             $rules=[
                 'id' => 'required|integer',
                 'type' => 'required|regex:/^[a-zA-Z]+$/u',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
                 $edit_unit = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $validator->errors()
                 ];
                 return response()->json($edit_unit);
             }
             // $check_this=unit::where('type',$request->type)->first();
             // if($check_this){
             //   $edit_unit=[
             //     'message' => 'Your Unit Is Already Exist',
             //     'success' => '0',
             //     'status' => 'false'
             //     ];
             // }else{
             $data = $request->all();
             $unit  = unit::find($request->id);
             if($unit){
               if($unit->update($data)){
                 $edit_unit=[
                   'message' => 'Unit Has Been Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];
               }
             }else{
               $edit_unit=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
             }
           // }
          return response()->json($edit_unit);
        }

}
