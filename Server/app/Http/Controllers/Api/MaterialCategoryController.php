<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\material_catrgory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
class MaterialCategoryController extends Controller
{
  public function __construct(material_catrgory $material_catrgory)
  {
    $this->material_catrgory = $material_catrgory;
  }
  public function fetch_material_category(Request $request){
    if($request->searchText){
      $material_catrgory = material_catrgory::with('fetchMaterialCatrgoryForSearch');
      if ($request->searchColum == 'id'){
         $material_catrgory->where('material_category.'.$request->searchColum,$request->searchText);
       }else{
         $material_catrgory->where('material_category.'.$request->searchColum,'LIKE','%'.$request->searchText.'%');
       }
       $result = $material_catrgory->paginate(config('paginateRecord'));
      // ->where($request->searchColum,'LIKE','%'.$request->searchText.'%')
      // ->paginate(config('paginateRecord'));
        // $material_catrgory = $this->material_catrgory->fetchMaterialCatrgoryForSearch($request->searchColum,$request->searchText);
        return response()->json($result);
    }
    if($request->page && !$request->data_sort_order){
      $material_catrgory = material_catrgory::with('fetchMaterialCatrgoryByPage')->paginate(config('paginateRecord'));
        // $material_catrgory = $this->material_catrgory->fetchMaterialCatrgoryByPage();
        return response()->json($material_catrgory);
    }
    else if($request->data_sort_order){
      $material_catrgory = material_catrgory::with('fetchMaterialCatrgoryBySorting')->orderBy($request->sorted_colum,$request->data_sort_order)->paginate(config('paginateRecord'));
        // $material_catrgory = $this->material_catrgory->fetchMaterialCatrgoryBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($material_catrgory);
    }else if($request->parent){
      $material_catrgory = material_catrgory::with('fetchMaterialCatrgoryParent')->where('parent_id',0)->orwhere('parent_id',null)->get();
          // $material_catrgory = $this->material_catrgory->fetchMaterialCatrgoryParent($request->parent);
          return response()->json($material_catrgory);
    }
    $material_catrgory = material_catrgory::with('fetchMaterialCatrgory')->get();
    // $material_catrgory = $this->material_catrgory->fetchMaterialCatrgory();
    return response()->json($material_catrgory);
  }

  public function Activefetch_material_category(){
    $material_catrgory = material_catrgory::with('ActvfetchMaterialCatrgory')->where('material_category.'.'is_active',1)->get();
    return response()->json($material_catrgory);
  }

  public function add_material_category(Request $request){
    $rules=[
        'name' => 'required',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $add_material_category = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->errors()
        ];
        return response()->json($add_material_category);
    }
        $check_this=material_catrgory::where('name',$request->type)->first();
        if($check_this){
          $add_material_category=[
            'message' => 'Your material Category Is Already Exist',
            'success' => '0',
            'status' => 'false'
            ];
        }else{
          $data = $request->all();
          if($material_category = material_catrgory::create($data)){
          $add_material_category=[
            'data' => $material_category,
            'message' => 'Add material Category successfully',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
        $add_material_category=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
          ];
        }
      }
        return response()->json($add_material_category);
     }

     public function show_material_category($id){
           // $uid=$request->id;
           $get=material_catrgory::with('getrecord')->find($id);
           if($get){
             $show_material_catrgory=[
               'data' => $get,
               'message' => 'Material Catrgory Detail',
               'success' => '1',
               'status' => 'true'
             ];
           }else{
             $show_material_catrgory=[
               'message' => 'Something probelm in internal system',
               'success' => '0',
               'status' => 'false'
             ];
           }
           return response()->json($show_material_catrgory);
        }

        public function delete_material_category($id){
              // $uid=$request->id;
              $get=material_catrgory::find($id);
              if($get){
                  $del=material_catrgory::find($id)->delete();
                  $delete_material_catrgory=[
                    'message' => 'Material Catrgory Has Been Delete Successfully',
                    'success' => '1',
                    'status' => 'true'
                  ];
              }else{
                $delete_material_catrgory=[
                  'message' => 'Something probelm in internal system',
                  'success' => '0',
                  'status' => 'false'
                ];
              }
              return response()->json($delete_material_catrgory);
           }

           public function edit_material_category(Request $request){
             $rules=[
                 'id' => 'required|integer',
                 'name' => 'required',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
                 $edit_material_category = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $validator->errors()
                 ];
                 return response()->json($edit_material_category);
             }
             // $check_this=material_catrgory::where('type',$request->type)->first();
             // if($check_this){
             //   $edit_material_category=[
             //     'message' => 'Your Material Category Is Already Exist',
             //     'success' => '0',
             //     'status' => 'false'
             //     ];
             // }else{
             $data = $request->all();
             $material_catergory  = material_catrgory::find($request->id);
             if($material_catergory){
               if($material_catergory->update($data)){
                 $edit_material_category=[
                   'message' => 'Material Category Has Been Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];
               }
             }else{
               $edit_material_category=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
             }
           // }
                return response()->json($edit_material_category);
        }

}
