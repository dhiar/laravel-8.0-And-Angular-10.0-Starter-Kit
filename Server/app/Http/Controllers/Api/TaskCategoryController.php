<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\taskCategory;
use Illuminate\Http\Request;
use Validator;
class TaskCategoryController extends Controller
{
  public function __construct(taskCategory $taskCategory)
  {
    $this->taskCategory = $taskCategory;
  }

  public function FetchTaskCategry(Request $request){
    if($request->searchText){
       $taskCategory = taskCategory::with('fetchTaskCatrgoryForSearch');
       if ($request->searchColum == 'id'){
          $taskCategory->where('task_category.'.$request->searchColum,$request->searchText);
        }else{
          $taskCategory->where('task_category.'.$request->searchColum,'LIKE','%'.$request->searchText.'%');
        }
        $result = $taskCategory->paginate(config('paginateRecord'));
       // ->where($request->searchColum,'LIKE','%'.$request->searchText.'%')
       // ->paginate(config('paginateRecord'));
        //  $taskCategory = $this->taskCategory->fetchTaskCatrgoryForSearch($request->searchColum,$request->searchText);
        return response()->json($result);
    }

    if($request->page && !$request->data_sort_order){
      $taskCategory = taskCategory::with('fetchTaskCatrgoryByPage')->paginate(config('paginateRecord'));
        // $taskCategory = $this->taskCategory->fetchTaskCatrgoryByPage();
        return response()->json($taskCategory);
    }
    else if($request->data_sort_order){
        $taskCategory=taskCategory::with('fetchTaskCatrgoryBySorting')->orderBy($request->sorted_colum,$request->data_sort_order)->paginate(config('paginateRecord'));
        // $taskCategory = $this->taskCategory->fetchTaskCatrgoryBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($taskCategory);
    }else if($request->parent){
      $taskCategory=taskCategory::with('fetchTaskCatrgoryParent')->where('parent_id',0)->orwhere('parent_id',null)->get();
          // $taskCategory = $this->taskCategory->fetchTaskCatrgoryParent($request->parent);
          return response()->json($taskCategory);
    }
    $taskCategory = taskCategory::with('fetchTaskCategory')->get();
    // $taskCategory = $this->taskCategory->fetchTaskCategory();
    return response()->json($taskCategory);
  }

  public function ActiveFetchTaskCategry(){
    $taskCategory = taskCategory::with('ActivefetchTaskCategory')->where('task_category.'.'is_active',1)->get();
    return response()->json($taskCategory);
  }

  public function addTaskCategry(Request $request){
    $rules=[
        'name' => 'required|string',
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
        $add_task_category = [
            'status' => 'false',
            'success' => '0',
            'message' => $validator->messages()
        ];
        return response()->json($add_task_category);
    }
        $check_this=taskCategory::where('name',$request->type)->first();
        if($check_this){
          $add_task_category=[
            'message' => 'Your task Category Is Already Exist',
            'success' => '0',
            'status' => 'false'
            ];
        }else{
          $data = $request->all();
          if($material_category = taskCategory::create($data)){
          $add_task_category=[
            'data' => $material_category,
            'message' => 'Add material Category successfully',
            'success' => '1',
            'status' => 'true'
          ];
        }else{
        $add_task_category=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
          ];
        }
      }
        return response()->json($add_task_category);
     }

     public function showTaskCategry($id){
           // $uid=$request->id;
           $get=taskCategory::with('getrecord')->find($id);
           if($get){
             $show_task_catrgory=[
               'data' => $get,
               'message' => 'Task Catrgory Detail',
               'success' => '1',
               'status' => 'true'
             ];
           }else{
             $show_task_catrgory=[
               'message' => 'Something probelm in internal system',
               'success' => '0',
               'status' => 'false'
             ];
           }
           return response()->json($show_task_catrgory);
        }

        public function deleteTaskCategry($id){
              // $uid=$request->id;
              $get=taskCategory::find($id);
              if($get){
                  $del=taskCategory::find($id)->delete();
                  $delete_task_catrgory=[
                    'message' => 'Task Catrgory Has Been Delete Successfully',
                    'success' => '1',
                    'status' => 'true'
                  ];
              }else{
                $delete_task_catrgory=[
                  'message' => 'Something probelm in internal system',
                  'success' => '0',
                  'status' => 'false'
                ];
              }
              return response()->json($delete_task_catrgory);
           }

           public function editTaskCategry(Request $request){
             $rules=[
                 'id' => 'required|integer',
                 'name' => 'required|regex:/^[a-zA-Z]+$/u',
             ];
             $validator = Validator::make($request->all(),$rules);
             if($validator->fails()){
                 $edit_material_category = [
                     'status' => 'false',
                     'success' => '0',
                     'message' => $validator->messages()
                 ];
                 return response()->json($edit_material_category);
             }
             $data = $request->all();
             $task_catergory  = taskCategory::find($request->id);
             if($task_catergory){
               if($task_catergory->update($data)){
                 $edit_task_category=[
                   'message' => 'Task Category Has Been Successfully Updated',
                   'success' => '1',
                   'status' => 'true'
                 ];
               }
             }else{
               $edit_task_category=[
                 'message' => 'Something probelm in internal system',
                 'success' => '0',
                 'status' => 'false'
               ];
             }
           // }
                return response()->json($edit_task_category);
        }

}
