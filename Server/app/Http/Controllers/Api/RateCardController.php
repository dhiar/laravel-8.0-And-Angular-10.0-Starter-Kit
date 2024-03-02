<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\workforce_category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class RateCardController extends Controller
{
  public function __construct(workforce_rate_card $workforce_rate_card)
  {
    $this->workforce_category = $workforce_category;
  }

  public function FetchRateCard(Request $request){
    if($request->searchText){
        $workforce_category = $this->workforce_category->fetchworkforce_rate_cardForSearch($request->searchColum,$request->searchText);
        return response()->json($workforce_category);
    }
    if($request->page && !$request->data_sort_order){
        $workforce_category = $this->workforce_category->fetchworkforce_rate_cardByPage();
        return response()->json($workforce_category);
    }
    else if($request->data_sort_order){
        $workforce_category = $this->workforce_category->fetchworkforce_rate_cardBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($workforce_category);
    }
    $workforce_category = $this->workforce_category->fetchworkforce_rate_card();
    return response()->json($workforce_category);
  }

  public function add_RateCard(Request $request){

      $rules = [
          'name' => 'required',
          'parent_id' => 'required',
          'description' => 'required',
          'normal' => 'required',
          'over_time' => 'required',
          'weekend' => 'required',
          'g_h' => 'required',
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

      if($RateCard = workforce_category::create($data)){
          $add_RateCard = [
              'data' => $RateCard,
              'status' => true,
              'success' => 1,
              'message' => 'Task added successfully'
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

  public function getRateCard($id){
        // $uid=$request->id;
        $get=workforce_category::find($id);
        if($get){
          $show_workforce_rate_card=[
            'data' => $get,
            'message' => 'Workforce Rate Card Detail',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
          $show_workforce_rate_card=[
            'message' => 'Something probelm in internal system',
            'success' => '0',
            'status' => 'false'
          ];
        }
        return response()->json($show_workforce_rate_card);
     }


     public function deleteRateCard($id){
           // $uid=$request->id;
           $get=workforce_category::find($id);
           if($get){
               $del=workforce_category::find($id)->delete();
               $delete_workforce_rate_card=[
                 'message' => 'Work Force Rate Card Has Been Delete Successfully',
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

        public function RateCardUpdate(Request $request){
          $rules = [
              'name' => 'required',
              'parent_id' => 'required',
              'description' => 'required',
              'normal' => 'required',
              'over_time' => 'required',
              'weekend' => 'required',
              'g_h' => 'required',
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
          $pro_vender  = workforce_category::find($request->id);
          if($pro_vender){
            if($pro_vender->update($data)){
              $edit_workforceCategory=[
                'message' => 'Work Force Rate Card Has Been Successfully Updated',
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
