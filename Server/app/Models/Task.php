<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'task_code','hours','qty','description','name','category_id','is_active'
    ];

    public function getrecord($id){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('tasks')
          ->leftjoin('task_category', 'task_category.id', '=', 'tasks.category_id')
          ->select('task_category.name as categoryName','tasks.*')
          ->where('tasks.id',$id)->first();
          return $results;
    }

    public function fetchTaskForSearch($searchColum, $searchText) {
     $Task =  DB::table('tasks')
     ->leftjoin('task_category', 'task_category.id', '=', 'tasks.category_id')
     ->select('task_category.name as categoryName','tasks.*');
     if ($searchColum == 'id'){
        $Task->where('tasks.'.$searchColum,$searchText);
      }else{
        $Task->where('tasks.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $Task->paginate(config('paginateRecord'));
      return $result;
     // ->where('tasks.'. $searchColum,'LIKE','%'.$searchText.'%')
     // ->paginate(config('paginateRecord'));
     // return $Task;
    }
    public function fetchTaskByPage() {
        $Task =DB::table('tasks')
        ->leftjoin('task_category', 'task_category.id', '=', 'tasks.category_id')
        ->select('task_category.name as categoryName','tasks.*')
        ->paginate(config('paginateRecord'));
        return $Task;
    }

    public function fetchTaskBySorting($sorted_colum, $data_sort_order) {
        $Task = DB::table('tasks')
        ->leftjoin('task_category', 'task_category.id', '=', 'tasks.category_id')
        ->select('task_category.name as categoryName','tasks.*')
        ->orderBy($sorted_colum,$data_sort_order)->paginate(config('paginateRecord'));
        return $Task;
    }
    public function fetchTask() {
      $Task=DB::table('tasks')
      ->leftjoin('task_category', 'task_category.id', '=', 'tasks.category_id')
      ->select('task_category.name as categoryName','tasks.*')
      ->get();
      return $Task;
     }

     public function ActivefetchTask() {
       $Task=DB::table('tasks')
       ->leftjoin('task_category', 'task_category.id', '=', 'tasks.category_id')
       ->select('task_category.name as categoryName','tasks.*')
       ->where('tasks.'.'is_active',1)->get();
       return $Task;
      }
}
