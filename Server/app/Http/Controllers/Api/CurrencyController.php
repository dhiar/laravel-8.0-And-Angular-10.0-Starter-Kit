<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\currencies;
use Validator;
use Illuminate\Http\Request;
use DB;
class CurrencyController extends Controller
{
  public function __construct(currencies $currencies)
  {
    $this->currencies = $currencies;
  }
  public function fetchCurrencies(Request $request){
    if($request->searchText){
        $currencies = $this->currencies->fetchcurrenciesForSearch($request->searchColum,$request->searchText);
        return response()->json($currencies);
    }
    if($request->page && !$request->data_sort_order){
        $currencies = $this->currencies->fetchcurrenciesByPage();
        return response()->json($currencies);
    }
    else if($request->data_sort_order){
        $currencies = $this->currencies->fetchcurrenciesBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($currencies);
    }
    $currencies = $this->currencies->fetchcurrencies();
    return response()->json($currencies);
  }

  public function activefetchCurrencies(){
    $currencies = $this->currencies->actvfetchcurrencies();
    return response()->json($currencies);
  }

  public function add_currency(Request $request){
    $rules=[
        'title' => 'required',
        'code' => 'required|regex:/^[a-zA-Z]+$/u',
        'decimal_point' => 'required',
        'value' => 'required',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $errors_array = array();
        foreach($validator->errors()->getMessages() as $key => $message){
            $errors_array[$key] = $message[0];
        }
        $add_currency = [
            'status' => false,
            'success' => 0,
            'message' => $errors_array
        ];
        return response()->json($add_currency);
    }
        // if($request->is_default == 1){
        //   DB::table('currencies')->where('is_default',1)->update(['is_default' => 0]);
        // }
        // $addCurrency=new currencies();
        // $addCurrency->title=$request->title;
        // $addCurrency->code=$request->code;
        // $addCurrency->symbol_position=$request->symbol_position;
        // $addCurrency->symbol=$request->symbol;
        // $addCurrency->decimal_point=$request->decimal_point;
        // $addCurrency->value=$request->value;
        // $addCurrency->is_default=$request->is_default;
        // $addCurrency->save();
        // if($addCurrency->save()){
          $data = $request->all();
        if($currency = currencies::create($data)){
          // $lastid=$addCurrency->id;
          // $get=currencies::where('id',$lastid)->first();
          $add_currency=[
            'data' => $currency,
            'message' => 'Add Currency successfully',
            'success' => 1,
            'status' => true
          ];
        }else{
        $add_currency=[
          'message' => 'Something probelm in internal system',
          'success' => 0,
          'status' => false
          ];
        }
        return response()->json($add_currency);
     }

     public function show_currency($id){
           // $uid=$request->id;
           $get=currencies::find($id);
           if($get){
             $show_currency=[
               'data' => $get,
               'message' => 'Currency Detail',
               'success' => 1,
               'status' => true
             ];
           }else{
             $show_currency=[
               'message' => 'Something probelm in internal system',
               'success' => 0,
               'status' => false
             ];
           }
           return response()->json($show_currency);
        }

        public function delete_currency($id){
              // $uid=$request->id;
              $get=currencies::find($id);
              if($get){
                  $del=currencies::find($id)->delete();
                  $delete_currency=[
                    'message' => 'Currency Has Been Delete Successfully',
                    'success' => 1,
                    'status' => true
                  ];
              }else{
                $delete_currency=[
                  'message' => 'Something probelm in internal system',
                  'success' => 0,
                  'status' => false
                ];
              }
              return response()->json($delete_currency);
           }

           public function edit_currency(Request $request){
             $rules=[
                 'id' => 'required|integer',
                 'title' => 'required',
                 'code' => 'required',
                 'decimal_point' => 'required',
                 'value' => 'required',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
               $errors_array = array();
               foreach($validator->errors()->getMessages() as $key => $message){
                   $errors_array[$key] = $message[0];
               }
                 $edit_currency = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $errors_array
                 ];
                 return response()->json($edit_currency);
             }
              $data = $request->all();
              $currency  = currencies::find($request->id);
             if($currency){
               // DB::table('currencies')->where('is_default',1)->update(['is_default' => 0]);
                 $currency->update($data);
                 $edit_currency=[
                   'message' => 'Currency Has Been Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];

             }else{
               $edit_currency=[
                 'message' => 'Currency Id Does Not Exist',
                 'success' => '0',
                 'status' => 'false'
               ];
           }
                return response()->json($edit_currency);
        }
}
