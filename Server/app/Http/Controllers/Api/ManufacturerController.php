<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Manufacturers;
use Validator;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
  public function __construct(manufacturers $manufacturers)
  {
    $this->manufacturers = $manufacturers;
  }
  public function fetchmanufacturers(Request $request){
    if($request->searchText){
        $manufacturers = $this->manufacturers->fetchmanufacturersForSearch($request->searchColum,$request->searchText);
        return response()->json($manufacturers);
    }
    if($request->page && !$request->data_sort_order){
        $manufacturers = $this->manufacturers->fetchmanufacturersByPage();
        return response()->json($manufacturers);
    }
    else if($request->data_sort_order){
        $manufacturers = $this->manufacturers->fetchmanufacturersBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($manufacturers);
    }
    $manufacturers = $this->manufacturers->fetchmanufacturers();
    return response()->json($manufacturers);
  }

  public function Activemanufacturers(){
    $manufacturers = $this->manufacturers->actvfetchmanufacturers();
    return response()->json($manufacturers);
  }

  public function add_manufacturers(Request $request){
    $rules=[
        'name' => 'required',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $add_manufacturer = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->messages()
        ];
        return response()->json($add_manufacturer);
    }
        $check_this=Manufacturers::where('name',$request->name)->first();
        if($check_this){
          $add_manufacturer=[
            'message' => 'Your manufacturer Is Already Exist',
            'success' => '0',
            'status' => 'false'
            ];
        }else{
          $data = $request->all();
          if($manufacturer = Manufacturers::create($data)){
          $add_manufacturer=[
            'data' => $manufacturer,
            'message' => 'Add manufacturer successfully',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
        $add_manufacturer=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
          ];
        }
      }
        return response()->json($add_manufacturer);
     }

     public function show_manufacturers($id){
           // $uid=$request->id;
           $get=Manufacturers::find($id);
           if($get){
             $show_manufacturer=[
               'data' => $get,
               'message' => 'Manufacturer Detail',
               'success' => '1',
               'status' => 'true'
             ];
           }else{
             $show_manufacturer=[
               'message' => 'Something probelm in internal system',
               'success' => '0',
               'status' => 'false'
             ];
           }
           return response()->json($show_manufacturer);
        }

        public function delete_manufacturers($id){
              // $uid=$request->id;
              $get=Manufacturers::find($id);
              if($get){
                  $del=Manufacturers::find($id)->delete();
                  $delete_Manufacturers=[
                    'message' => 'Manufacturers Has Been Delete Successfully',
                    'success' => '1',
                    'status' => 'true'
                  ];
              }else{
                $delete_Manufacturers=[
                  'message' => 'Something probelm in internal system',
                  'success' => '0',
                  'status' => 'false'
                ];
              }
              return response()->json($delete_Manufacturers);
           }
        //
           public function edit_manufacturers(Request $request){
             $rules=[
                 'id' => 'required',
                 'name' => 'required',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
                 $edit_Manufacturers = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $validator->messages()
                 ];
                 return response()->json($edit_Manufacturers);
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
             $Manufacturers  = Manufacturers::find($request->id);
             if($Manufacturers){
               if($Manufacturers->update($data)){
                 $edit_Manufacturers=[
                   'message' => 'Manufacturers Has Been Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];
               }
             }else{
               $edit_Manufacturers=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
             }
           // }
          return response()->json($edit_Manufacturers);
        }
}
