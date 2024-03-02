<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\agencies;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AgencyController extends Controller
{
  protected $agencies;
  public function __construct(agencies $agencies)
  {
    $this->agencies = $agencies;
  }
  public function FetchAgencies(Request $request){
    if($request->searchText){
        $agencies = $this->agencies->fetchAgenciesForSearch($request->searchColum,$request->searchText);
        return response()->json($agencies);
    }
    if($request->page && !$request->data_sort_order){
        $agencies = $this->agencies->fetchAgenciesByPage();
        return response()->json($agencies);
    }
    else if($request->data_sort_order){
        $agencies = $this->agencies->fetchAgenciesBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($agencies);
    }
    $agencies = $this->agencies->fetchAgencies();
    return response()->json($agencies);
  }

  public function ActiveFetchAgencies(){
    $agencies = $this->agencies->ActivesfetchAgencies();
    return response()->json($agencies);
  }
  public function add_agency(Request $request){

      $rules = [
          'agency_name' => 'required|string',
          'contacted_person' => 'required|string',
          'phone' => 'required',
          'first_email' => 'required',
          'second_email' => 'required',
          // 'second_email' => 'required|string|email|regex:/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails()){
          $add_agency = [
              'status' => false,
              'success' => 0,
              'message' => $validator->errors()
          ];
          return response()->json($add_agency);
      }
      if($request->first_email == $request->second_email){
        $add_agency = [
            'status' => false,
            'success' => 0,
            'message' => 'Optional Email Will Not Same'
        ];
      }else{
        $data = $request->all();
        if($agency = agencies::create($data)){
            $add_agency = [
                'data' => $agency,
                'status' => true,
                'success' => 1,
                'message' => 'Agency added successfully'
            ];
        }else{
            $add_agency = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
        }
      }
        return response()->json($add_agency);
  }

  public function show_agency($id){
        // $uid=$request->id;
        if($id){
            $agencies = $this->agencies->getcountry($id);
            if($agencies){
              $show_agency=[
                  'data' => $agencies,
                  'message' => 'Agency Detail',
                  'success' => '1',
                  'status' => 'true'
                ];
            }
        }else{
          $show_agency=[
            'message' => 'Something probelm in internal system',
            'success' => '0',
            'status' => 'false'
          ];
        }
        return response()->json($show_agency);
        // $get=agencies::with('getcountry:id,name')->find($id);
        // if($get){
        //   $show_agency=[
        //     'data' => $get,
        //     'message' => 'Agency Detail',
        //     'success' => '1',
        //     'status' => 'true'
        //   ];
        // }else{
        //   $show_agency=[
        //     'message' => 'Something probelm in internal system',
        //     'success' => '0',
        //     'status' => 'false'
        //   ];
        // }
        // return response()->json($show_agency);
     }
     public function delete_agency($id){
           // $uid=$request->id;
           $get=agencies::find($id);
           if($get){
               $del=agencies::find($id)->delete();
               $delete_unit=[
                 'message' => 'Agency Has Been Delete Successfully',
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


        public function edit_agency(Request $request){
          $rules = [
              'id' => 'required|integer',
              'agency_name' => 'required|string',
              'contacted_person' => 'required|string',
              'phone' => 'required',
              'first_email' => 'required',
              'second_email' => 'required',
              // 'second_email' => 'required|string|email|regex:/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
          ];
          $validator = Validator::make($request->all(),$rules);
          if($validator->fails()){
              $edit_agency = [
                  'status' => 'false',
                  'success' => '0',
                  'message' => $validator->errors()
              ];
              return response()->json($edit_agency);
          }
          // $check_this=agencies::where('first_email',$request->first_email)->first();
          // if($check_this){
          //   $edit_agency=[
          //     'message' => 'Your Email Is Already Exist',
          //     'success' => '0',
          //     'status' => 'false'
          //     ];
          // }else{
          $data = $request->all();
          $agency  = agencies::find($request->id);
          if($agency){
            if($agency->update($data)){
              $edit_agency=[
                'message' => 'agency Has Been Successfully Updated',
                'success' => '1',
                'status' => 'true'
              ];
            }
          }else{
            $edit_agency=[
              'message' => 'Something probelm in internal system',
              'success' => '0',
              'status' => 'false'
            ];
          }
        // }
       return response()->json($edit_agency);
     }
}
