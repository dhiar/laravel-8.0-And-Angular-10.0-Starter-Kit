<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;

class TaskController extends Controller
{
  public function __construct(Task $Task)
  {
    $this->Task = $Task;
  }
    public function getAllTask(Request $request){
      if($request->searchText){
          $Task = $this->Task->fetchTaskForSearch($request->searchColum,$request->searchText);
          return response()->json($Task);
      }
      if($request->page && !$request->data_sort_order){
          $Task = $this->Task->fetchTaskByPage();
          return response()->json($Task);
      }
      else if($request->data_sort_order){
          $Task = $this->Task->fetchTaskBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($Task);
      }
      $Task = $this->Task->fetchTask();
      return response()->json($Task);
    }

    public function ActivegetAllTask(){
      $Task = $this->Task->ActivefetchTask();
      return response()->json($Task);
    }

    public function taskStore(Request $request){

        $rules = [
            'task_code' => 'required|string',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'hours' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }
        $data = $request->all();
        $taskName=$request->name;
        $taskCode=$request->task_code;
        $check=Task::where('name',$taskName)->orwhere('task_code',$taskCode)->first();
        if($check){
          $response = [
              'status' => false,
              'success' => 0,
              'message' => 'Task Already Exist'
          ];
        }else{
          if($task = Task::create($data)){
              $response = [
                  'data' => $task,
                  'status' => true,
                  'success' => 1,
                  'message' => 'Task added successfully'
              ];
              return response()->json($response);
          }
        }
        return response()->json($response);
    }

    public function taskUpdate(Request $request){

      $rules = [
          'task_code' => 'required|string',
          'name' => 'required|string',
          'category_id' => 'required|integer',
          'hours' => 'required|numeric',
      ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }
        $data = $request->all();

        $task = Task::find($request->id);
        if($task->update($data)){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Task updated successfully'
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
            return response()->json($response);
        }

    }

    public function getTaskById($id=0){
      $task = $this->Task->getrecord($id);
      if($task){
        $show_Task=[
                  'data' => $task,
                  'message' => 'Task Detail',
                  'success' => '1',
                  'status' => 'true'
                ];
      }else{
        $show_Task=[
            'message' => 'Something probelm in internal system',
            'success' => '0',
            'status' => 'false'
          ];
      }
        return response()->json($show_Task);

    }

    public function deleteTask($id=0){

        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }

        $task = Task::find($id);
        if($task->delete()){

            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Task deleted successfully'
            ];

        }else{

            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
        }
        return response()->json($response);
    }

}
