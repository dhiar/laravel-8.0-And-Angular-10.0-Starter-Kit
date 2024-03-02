<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\quotation_status;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class QuotationStatusController extends Controller
{
  public function __construct(quotation_status $quotation_status)
  {
    $this->quotation_status = $quotation_status;
  }
  public function FetchQuotationStatus(Request $request){
    if($request->searchText){
        $quotation_status = $this->quotation_status->fetchQuotationStatusForSearch($request->searchColum,$request->searchText);
        return response()->json($quotation_status);
    }
    if($request->page && !$request->data_sort_order){
        $quotation_status = $this->quotation_status->fetchQuotationStatusByPage();
        return response()->json($quotation_status);
    }
    else if($request->data_sort_order){
        $quotation_status = $this->quotation_status->fetchQuotationStatusBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($quotation_status);
    }
    $quotation_status = $this->quotation_status->fetchQuotationStatus();
    return response()->json($quotation_status);
  }

  public function quotationStatusStore(Request $request){

      $rules = [
          'name' => 'required',
          'color_code' => 'required',
          'status_code' => 'required',
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails()){
          $add_quotation_status = [
              'status' => false,
              'success' => 0,
              'message' => $validator->errors()
          ];
          return response()->json($add_quotation_status);
      }
        $data = $request->all();
        if($quotationStatus = quotation_status::create($data)){
            $add_quotation_status = [
                'data' => $quotationStatus,
                'status' => true,
                'success' => 1,
                'message' => 'Quotation Status added successfully'
            ];
        }else{
            $add_quotation_status = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
        }
        return response()->json($add_quotation_status);
  }

  public function GetQuotationStatus($id){
    if($id){
        $getquotationStatus = $this->quotation_status->getquotationsStatus($id);
        if($getquotationStatus){
          $show_quotationStatus=[
              'data' => $getquotationStatus,
              'message' => 'Quotation Status Detail',
              'success' => '1',
              'status' => 'true'
            ];
        }
    }else{
      $show_quotationStatus=[
        'message' => 'Something probelm in internal system',
        'success' => '0',
        'status' => 'false'
      ];
    }
    return response()->json($show_quotationStatus);
  }

  public function DeleteQuotationStatus($id){
    // $uid=$request->id;
    $get=quotation_status::where('id',$id)->delete();
    if($get){
      $del_quotationStatus=[
        'message' => 'Quotation Status Has Been Delete Successfully',
        'success' => '1',
        'status' => 'true'
      ];
    }else{
      $del_quotationStatus=[
        'message' => 'Something probelm in internal system',
        'success' => '0',
        'status' => 'false'
      ];
    }
    return response()->json($del_quotationStatus);
  }

  public function UpdateQuotationStatus(Request $request){
    $rules = [
        'id' => 'required',
        'name' => 'required',
        'color_code' => 'required',
        'status_code' => 'required',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $edit_quotationStatus = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->errors()
        ];
        return response()->json($edit_quotationStatus);
    }
    $data = $request->all();
    $quotation  = quotation_status::find($request->id);
    if($quotation){
      if($quotation->update($data)){
        $edit_quotationStatus=[
          'message' => 'Quotation Status Has Been Successfully Updated',
          'success' => '1',
          'status' => 'true'
        ];
      }
    }else{
      $edit_quotationStatus=[
        'message' => 'Something probelm in internal system',
        'success' => '0',
        'status' => 'false'
      ];
    }
  // }
 return response()->json($edit_quotationStatus);
}
}
