<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\employee_detail;
use Validator;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  public function __construct(employee_detail $employee_detail)
  {
    $this->employee_detail = $employee_detail;
  }
  public function FetchEmployeeDetail(Request $request){
    if($request->searchText){
        $employee_detail = $this->employee_detail->fetchEmployeeDetailForSearch($request->searchColum,$request->searchText);
        return response()->json($employee_detail);
    }
    if($request->page && !$request->data_sort_order){
        $employee_detail = $this->employee_detail->fetchEmployeeDetailByPage();
        return response()->json($employee_detail);
    }
    else if($request->data_sort_order){
        $employee_detail = $this->employee_detail->fetchEmployeeDetailBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($employee_detail);
    }
    $employee_detail = $this->employee_detail->fetchEmployeeDetail();
    return response()->json($employee_detail);
  }

  public function add_employee_detail(Request $request){
    $rules=[
        'category_id' => 'required|integer',
        'wrench_time' => 'required|string',
        'zone_id' => 'required|integer',
        'employee_type' => 'required|integer',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $add_employee_detail = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->messages()
        ];
        return response()->json($add_employee_detail);
    }
        $addProductvender=new employee_detail();
        $addProductvender->user_id=$request->user_id;
        $addProductvender->category_id=$request->category_id;
        $addProductvender->wrench_time=$request->wrench_time;
        $addProductvender->zone_id=$request->zone_id;
        $addProductvender->agency_id =$request->agency_id;
        $addProductvender->employee_type=$request->employee_type;
        $addProductvender->save();
        if($addProductvender->save()){
          $lastid=$addProductvender->id;
          $get=employee_detail::where('id',$lastid)->first();
          $add_employee_detail=[
            'product_vender' => $get,
            'message' => 'Add Product Vender successfully',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
        $add_employee_detail=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
          ];
        }
        return response()->json($add_employee_detail);
     }

     public function show_employee_detail($id){
           $EmployeeDetail = $this->employee_detail->getrecord($id);
           if($EmployeeDetail){
             $show_EmployeeDetail=[
                       'data' => $EmployeeDetail,
                       'message' => 'Employee Detail',
                       'success' => '1',
                       'status' => 'true'
                     ];
           }else{
             $show_EmployeeDetail=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
           }
             return response()->json($show_EmployeeDetail);
          }

        public function delete_employee_detail($id){
              // $uid=$request->id;
              $get=employee_detail::find($id);
              if($get){
                  $del=employee_detail::find($id)->delete();
                  $delete_employee_detail=[
                    'message' => 'Employee Detail Has Been Delete Successfully',
                    'success' => '1',
                    'status' => 'true'
                  ];
              }else{
                $delete_employee_detail=[
                  'message' => 'Something probelm in internal system',
                  'success' => '0',
                  'status' => 'false'
                ];
              }
              return response()->json($delete_employee_detail);
           }


           public function edit_employee_detail(Request $request){
             $rules=[
                 'id' => 'required|integer',
                 'category_id' => 'required|integer',
                 'wrench_time' => 'required|string',
                 'zone_id' => 'required|integer',
                 'employee_type' => 'required|integer',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
                 $edit_employee_detail = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $validator->messages()
                 ];
                 return response()->json($edit_employee_detail);
             }

             $data = $request->all();
             $emp_detail  = employee_detail::find($request->id);
             if($emp_detail){
               if($emp_detail->update($data)){
                 $edit_employee_detail=[
                   'message' => 'Employee Detail Has Been Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];
               }
             }else{
               $edit_employee_detail=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
             }
                return response()->json($edit_employee_detail);
             }
}
