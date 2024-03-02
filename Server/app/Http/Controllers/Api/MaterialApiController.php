<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\material;
use Illuminate\Support\Facades\Validator;
class MaterialApiController extends Controller
{
  public function __construct(material $material)
  {
    $this->material = $material;
  }
  public function FetchMaterial(Request $request){
    if($request->searchText){
        $material = $this->material->fetchmaterialForSearch($request->searchColum,$request->searchText);
        return response()->json($material);
    }
    if($request->page && !$request->data_sort_order){
        $material = $this->material->fetchmaterialByPage();
        return response()->json($material);
    }
    else if($request->data_sort_order){
        $material = $this->material->fetchmaterialBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($material);
    }
    $material = $this->material->fetchmaterial();
    return response()->json($material);
  }

  public function ActiveFetchMaterial(){
    $material = $this->material->actvfetchmaterial();
    return response()->json($material);
  }
  public function add_material(Request $request){

    $rules=[
        'name' => 'required|string',
        // 'name' => 'required|regex:/^[a-zA-Z,\&]+$/u',
        'category_id' => 'required|integer',
        'unit_price' => 'required|numeric',
        'vendor_id' => 'required|integer',
        'currency_id' => 'required|integer',
        'unit' => 'required|integer',
        'reference_no_vender' => 'required|string',
        'manufacturer_id' => 'required|integer',
        'manufacturer_code' => 'required|string',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $add_material = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->errors()
        ];
        return response()->json($add_material);
    }

$data = $request->all();
if($material = material::create($data)){
        // $addmaterial=new material();
        // $addmaterial->name=$request->name;
        // $addmaterial->category_id=$request->category_id;
        // $addmaterial->unit_price=$request->unit_price;
        // $addmaterial->currency_id=$request->currency_id;
        // $addmaterial->unit=$request->unit;
        // $addmaterial->sku_no=$request->sku_no;
        // $addmaterial->reference_no_vender=$request->reference_no_vender;
        // $addmaterial->description=$request->description;
        // $addmaterial->vendor_id=$request->vendor_id;
        // $addmaterial->save();
        // if($addmaterial->save()){
        //   $lastid=$addmaterial->id;
        //   $get=material::where('id',$lastid)->first();
          $add_material=[
            'data' => $material,
            'message' => 'Add Material successfully',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
        $add_material=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
          ];
        }

        return response()->json($add_material);
     }

     public function show_material($id){
       $getId=material::find($id);
       if($getId){
         $product = $this->material->getrecord($id);
         if($product){
           $show_material=[
               'data' => $product,
               'message' => 'Material Detail',
               'success' => '1',
               'status' => 'true'
             ];
         }
       }else{
         $show_material=[
           'message' => 'Something probelm in internal system',
           'success' => '0',
           'status' => 'false'
         ];
       }
       return response()->json($show_material);
    }

        public function delete_material($id){
              // $uid=$request->id;
              $get=material::find($id);
              if($get){
                  $del=material::find($id)->delete();
                  $delete_material=[
                    'message' => 'Material Has Been Delete Successfully',
                    'success' => '1',
                    'status' => 'true'
                  ];
              }else{
                $delete_material=[
                  'message' => 'Something probelm in internal system',
                  'success' => '0',
                  'status' => 'false'
                ];
              }
              return response()->json($delete_material);
           }

           public function edit_material(Request $request){
             $rules=[
                 'id' => 'required|integer',
                 'name' => 'required|string',
                 'category_id' => 'required|integer',
                 'unit_price' => 'required',
                 'currency_id' => 'required|integer',
                 'vendor_id' => 'required|integer',
                 'unit' => 'required|integer',
                 'reference_no_vender' => 'required|string',
                 'manufacturer_id' => 'required|integer',
                 'manufacturer_code' => 'required|string',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
                 $edit_material = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $validator->errors()
                 ];
                 return response()->json($edit_material);
             }

             $data = $request->all();
             $material  = material::find($request->id);
             if($material){
               if($material->update($data)){
                 $edit_material=[
                   'message' => 'Material Has Been Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];
               }
             }else{
               $edit_material=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
             }
          return response()->json($edit_material);
        }
}
