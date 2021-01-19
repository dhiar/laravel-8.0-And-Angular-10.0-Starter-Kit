<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product_vender;
use App\Models\product_category;

use Validator;
class ProductApiController extends Controller
{

  public function __construct(product_vender $product_vender)
  {
    $this->product_vender = $product_vender;
  }
  public function FetchProductVender(Request $request){
    if($request->searchText){
        $product_vender = $this->product_vender->fetchProductVenderForSearch($request->searchColum,$request->searchText);
        return response()->json($product_vender);
    }
    if($request->page && !$request->data_sort_order){
        $product_vender = $this->product_vender->fetchProductVenderByPage();
        return response()->json($product_vender);
    }
    else if($request->data_sort_order){
        $product_vender = $this->product_vender->fetchProductVenderBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($product_vender);
    }
    $product_vender = $this->product_vender->fetchProductVender();
    return response()->json($product_vender);
  }

  public function ActiveFetchProductVender(){
    $product_vender = $this->product_vender->actvfetchProductVender();
    return response()->json($product_vender);
  }

  public function add_product_vender(Request $request){
    $rules=[
        'vender_name' => 'required|string',
        'vender_first_email' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'country_id' => 'required|integer',
        'common_id' => 'required|integer',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $add_Product_vender = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->messages()
        ];
        return response()->json($add_Product_vender);
    }

    $mail=$request->vender_first_email ;
    $select=product_vender::where('vender_first_email',$mail)->first();
    if($select){
      $add_Product_vender=[
        'message' => 'Distributors Email Already Exist',
        'success' => '0',
        'status' => 'false'
      ];
    }else{

        // $addProductvender=new product_vender();
        // $addProductvender->vender_name=$request->vender_name;
        // $addProductvender->vender_first_email=$request->vender_first_email;
        // $addProductvender->vender_second_email=$request->vender_second_email;
        // $addProductvender->code=$request->code;
        // $addProductvender->phone=$request->phone;
        // $addProductvender->address =$request->address;
        // $addProductvender->country_id=$request->country_id;
        // $addProductvender->city=$request->city;
        // $addProductvender->state=$request->state;
        // $addProductvender->common_id=$request->common_id;
        // $addProductvender->save();
        $data = $request->all();
        if($distributor = product_vender::create($data)){
          // $lastid=$addProductvender->id;
          // $get=product_vender::where('id',$lastid)->first();
          $add_Product_vender=[
            'product_vender' => $distributor,
            'message' => 'Add Distributors successfully',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
        $add_Product_vender=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
          ];
        }
      }
        return response()->json($add_Product_vender);
     }

     public function show_product_vender($id){
       $ProductVender = $this->product_vender->getrecord($id);
       if($ProductVender){
         $show_ProductVender=[
                   'data' => $ProductVender,
                   'message' => 'Distributors Detail',
                   'success' => '1',
                   'status' => 'true'
                 ];
       }else{
         $show_ProductVender=[
             'message' => 'Something probelm in internal system',
             'success' => '0',
             'status' => 'false'
           ];
       }
         return response()->json($show_ProductVender);
      }

        public function delete_product_vender($id){
              // $uid=$request->id;
              $del=product_vender::find($id)->delete();
              if($del){
                $delete_product_vender=[
                  'message' => 'Distributor Delete Successfully',
                  'success' => '1',
                  'status' => 'true'
                ];
              }else{
                $delete_product_vender=[
                  'message' => 'Something probelm in internal system',
                  'success' => '0',
                  'status' => 'false'
                ];
              }
              return response()->json($delete_product_vender);
           }


           public function edit_product_vender(Request $request){
             $rules=[
                 'id' => 'required|integer',
                 'vender_name' => 'required|string',
                 'vender_first_email' => 'required',
                 'phone' => 'required',
                 'address' => 'required',
                 'country_id' => 'required|integer',
                 'common_id' => 'required|integer',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
                 $edit_product_vender = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $validator->messages()
                 ];
                 return response()->json($edit_product_vender);
             }

             $data = $request->all();
             $pro_vender  = product_vender::find($request->id);
             if($pro_vender){
               if($pro_vender->update($data)){
                 $edit_product_vender=[
                   'message' => 'Distributors Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];
               }
             }else{
               $edit_product_vender=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
             }
                return response()->json($edit_product_vender);
             }

             // public function add_product_category(Request $request){
             //   // $parentid='';
             //   $rules=[
             //       'category_name' => 'required|string',
             //   ];
             //
             //   $validator = Validator::make($request->all(),$rules);
             //   if($validator->fails()){
             //       $add_product_category = [
             //           'status' => 'false',
             //           'success' => '0',
             //           'message' => $validator->messages()
             //       ];
             //       return response()->json($add_product_category);
             //   }
             //    // $getproductcategory=product_category::all();
             //    // $c=count($getproductcategory);
             //    // if($c <= 0){
             //    //   $parentid=$request->parent_id;
             //    //   print_r('1');
             //    // }else{
             //    //     $parentid=0;
             //    //     print_r('2');
             //    // }
             //     $addProductCategory=new product_category();
             //     $addProductCategory->category_name=$request->category_name;
             //     $addProductCategory->parent_id=$request->parent_id;
             //     $addProductCategory->save();
             //     if($addProductCategory->save()){
             //       $lastid=$addProductCategory->id;
             //       $get=product_category::find($lastid);
             //       $get_product_Category=[
             //         'data' => $get,
             //         'message' => 'product Category List',
             //         'success' => '1',
             //         'status' => 'true'
             //       ];
             //     }else{
             //       $get_product_Category=[
             //         'message' => 'Something probelm in internal system',
             //         'success' => '0',
             //         'status' => 'false'
             //       ];
             //     }
             //     return response()->json($get_product_Category);
             // }
             //

}
