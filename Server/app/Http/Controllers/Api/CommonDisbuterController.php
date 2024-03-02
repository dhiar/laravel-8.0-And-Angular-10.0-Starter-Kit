<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\CommonDistributor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CommonDisbuterController extends Controller
{
  protected $commondistributor;
  public function __construct(commondistributor $commondistributor)
  {
    $this->commondistributor = $commondistributor;
  }
  public function fetchCommonDisbuter(Request $request){
    if($request->searchText){
        $commondistributor = $this->commondistributor->fetchcommondistributorForSearch($request->searchColum,$request->searchText);
        return response()->json($commondistributor);
    }
    if($request->page && !$request->data_sort_order){
        $commondistributor = $this->commondistributor->fetchcommondistributorByPage();
        return response()->json($commondistributor);
    }
    else if($request->data_sort_order){
        $commondistributor = $this->commondistributor->fetchcommondistributorBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($commondistributor);
    }
    $commondistributor = $this->commondistributor->fetchcommondistributor();
    return response()->json($commondistributor);
  }

  public function ActiveCommonDisbuter(){
    $commondistributor = $this->commondistributor->actvfetchcommondistributor();
    return response()->json($commondistributor);
  }

  public function add_CommonDisbuter(Request $request){
    $rules=[
        'name' => 'required',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $add_CommonDistributor = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->errors()
        ];
        return response()->json($add_CommonDistributor);
    }
        $check_this=CommonDistributor::where('name',$request->name)->first();
        if($check_this){
          $add_CommonDistributor=[
            'message' => 'Your Common Distributor Is Already Exist',
            'success' => '0',
            'status' => 'false'
            ];
        }else{
          $data = $request->all();
          if($CommonDistributor = CommonDistributor::create($data)){
          $add_CommonDistributor=[
            'data' => $CommonDistributor,
            'message' => 'Add Common Distributor successfully',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
        $add_CommonDistributor=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
          ];
        }
      }
        return response()->json($add_CommonDistributor);
     }

     public function show_CommonDisbuter($id){
           // $uid=$request->id;
           $get=CommonDistributor::find($id);
           if($get){
             $show_CommonDistributor=[
               'data' => $get,
               'message' => 'Common Distributor Detail',
               'success' => '1',
               'status' => 'true'
             ];
           }else{
             $show_CommonDistributor=[
               'message' => 'Something probelm in internal system',
               'success' => '0',
               'status' => 'false'
             ];
           }
           return response()->json($show_CommonDistributor);
        }

        public function delete_CommonDisbuter($id){
              // $uid=$request->id;
              $get=CommonDistributor::find($id);
              if($get){
                  $del=CommonDistributor::find($id)->delete();
                  $delete_CommonDistributor=[
                    'message' => 'Common Distributor Has Been Delete Successfully',
                    'success' => '1',
                    'status' => 'true'
                  ];
              }else{
                $delete_CommonDistributor=[
                  'message' => 'Something probelm in internal system',
                  'success' => '0',
                  'status' => 'false'
                ];
              }
              return response()->json($delete_CommonDistributor);
           }

           public function edit_CommonDisbuter(Request $request){
             $rules=[
                 'id' => 'required',
                 'name' => 'required',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
                 $edit_CommonDistributor = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $validator->errors()
                 ];
                 return response()->json($edit_CommonDistributor);
             }

             $data = $request->all();
             $CommonDistributor  = CommonDistributor::find($request->id);
             if($CommonDistributor){
               if($CommonDistributor->update($data)){
                 $edit_CommonDistributor=[
                   'message' => 'Common Distributor Has Been Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];
               }
             }else{
               $edit_CommonDistributor=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
             }

          return response()->json($edit_CommonDistributor);
        }
}
