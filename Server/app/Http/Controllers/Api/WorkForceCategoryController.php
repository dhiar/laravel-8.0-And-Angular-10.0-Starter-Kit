<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\workforcecategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class WorkForceCategoryController extends Controller
{
  public function __construct(workforcecategory $workforcecategory)
  {
    $this->workforcecategory = $workforcecategory;
  }
  public function Fetchworkforcecategory(Request $request){
    if($request->searchText){
        $workforcecategory = $this->workforcecategory->fetchworkforce_categoryForSearch($request->searchColum,$request->searchText);
        return response()->json($workforcecategory);
    }
    if($request->page && !$request->data_sort_order){
        $workforcecategory = $this->workforcecategory->fetchworkforce_categoryByPage();
        return response()->json($workforcecategory);
    }
    else if($request->data_sort_order){
        $workforcecategory = $this->workforcecategory->fetchworkforce_categoryBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($workforcecategory);
    }

    $workforcecategory = $this->workforcecategory->fetchworkforce_category();
    return response()->json($workforcecategory);
  }

public function ActiveFetchworkforcecategory(){
  $workforcecategory = $this->workforcecategory->actvfetchworkforce_category();
  return response()->json($workforcecategory);
}

  public function add_workforcecategory(Request $request){

      $rules = [
          'name' => 'required|string',
          'normal' => 'required|numeric',
          'decipline_id' => 'required|integer',
          'over_time' => 'required|numeric',
          'weekend' => 'required|numeric',
          'g_h' => 'required|numeric',
          'currency_id' => 'required|integer',
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails()){
          $add_RateCard = [
              'status' => false,
              'success' => 0,
              'message' => $validator->errors()
          ];
          return response()->json($add_RateCard);
      }
      $data = $request->all();

      if($RateCard = workforcecategory::create($data)){
          $add_RateCard = [
              'data' => $RateCard,
              'status' => true,
              'success' => 1,
              'message' => 'Work Force Category added successfully'
          ];
      }else{
          $add_RateCard = [
              'status' => false,
              'success' => 0,
              'message' => 'Something probelm in internal system'
          ];

      }
      return response()->json($add_RateCard);
  }

  public function getworkforcecategory($id){
        // $uid=$request->id;
        $get=workforcecategory::find($id);
        if($get){
          $show_workforce_category=[
            'data' => $get,
            'message' => 'Workforce Category Detail',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
          $show_workforce_category=[
            'message' => 'Something probelm in internal system',
            'success' => '0',
            'status' => 'false'
          ];
        }
        return response()->json($show_workforce_category);
     }

     public function deleteworkforcecategory($id){
           // $uid=$request->id;
           $get=workforcecategory::find($id);
           if($get){
               $del=workforcecategory::find($id)->delete();
               $delete_workforce_rate_card=[
                 'message' => 'Work Force Category Has Been Delete Successfully',
                 'success' => '1',
                 'status' => 'true'
               ];
           }else{
             $delete_workforce_rate_card=[
               'message' => 'Something probelm in internal system',
               'success' => '0',
               'status' => 'false'
             ];
           }
           return response()->json($delete_workforce_rate_card);
        }

        public function workforcecategoryUpdate(Request $request){
          $rules = [
              'id' => 'required|integer',
              'name' => 'required|string',
              'normal' => 'required|numeric',
              'decipline_id' => 'required|integer',
              'over_time' => 'required|numeric',
              'weekend' => 'required|numeric',
              'g_h' => 'required|numeric',
              'currency_id'=> 'required|integer',
          ];
          $validator = Validator::make($request->all(),$rules);
          if($validator->fails()){
              $edit_ratecard = [
                  'status' => 'false',
                  'success' => '0',
                  'message' => $validator->errors()
              ];
              return response()->json($edit_ratecard);
          }

          $data = $request->all();
          $pro_vender  = workforcecategory::find($request->id);
          if($pro_vender){
            if($pro_vender->update($data)){
              $edit_workforceCategory=[
                'message' => 'Work Force Category Has Been Successfully Updated',
                'success' => '1',
                'status' => 'true'
              ];
            }
          }else{
            $edit_workforceCategory=[
              'message' => 'Something probelm in internal system',
              'success' => '0',
              'status' => 'false'
            ];
          }
             return response()->json($edit_workforceCategory);
          }
}
