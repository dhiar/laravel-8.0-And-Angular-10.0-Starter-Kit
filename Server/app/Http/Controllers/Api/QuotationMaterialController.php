<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Quotations_Materials;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class QuotationMaterialController extends Controller
{
  public function quotationMaterialStore(Request $request){

      $rules = [
          'quotation_id' => 'required',
          'material_id' => 'required',
          'qty' => 'required',
          'price' => 'required',
          'currency_id' => 'required',
          'vender_id' => 'required',
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails()){
          $add_quotation_material = [
              'status' => false,
              'success' => 0,
              'message' => $validator->errors()
          ];
          return response()->json($add_quotation_material);
      }
      if($request->has('vvalue'))
          {
              $met=count($array);
              for($i=0; $i<$met;$i++)
              {
                $storeadmin=new VD();
                $storeadmin->vehicle_id=$addvehicle->id;
                $storeadmin->key_id=$request->v_key_id[$i];
                $storeadmin->key=$request->v_key_name[$i];
                $storeadmin->value=$request->vvalue[$i];
                $storeadmin->status='0';
                $storeadmin->add_data='A';
                $storeadmin->save();
              }
          }
      // if($request->contacted_person_email1 == $request->contacted_person_email2){
      //   $add_quotation_material = [
      //       'status' => false,
      //       'success' => 0,
      //       'message' => 'Optional Email Will Not Same'
      //   ];
      // }else{
        $data = $request->all();
        if($quotation = Quotations_Materials::create($data)){
            $add_quotation_material = [
                'data' => $quotation,
                'status' => true,
                'success' => 1,
                'message' => 'Quotation Material added successfully'
            ];
        }else{
            $add_quotation_material = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
        }
      // }
        return response()->json($add_quotation_material);
  }
}
