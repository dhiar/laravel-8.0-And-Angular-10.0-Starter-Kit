<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class taskCategory extends Model
{
    use HasFactory;
    protected $table="task_category";
    protected $fillable=['name','parent_id','description','is_active'];

    public function getrecord(){
          return $this->belongsTo(taskCategory::class, 'parent_id');
          // $workforce_category=DB::select("SELECT w_d.*,(select name from workforce_decipline as w_d2 where w_d2.id = w_d.parent_id) as parent_name FROM workforce_decipline AS w_d WHERE w_d.id=".$id);
          // return $workforce_category;
    }
    public function fetchTaskCatrgoryForSearch($searchColum, $searchText) {
      return $this->belongsTo(taskCategory::class, 'parent_id');
     // $task_catrgory =  taskCategory::where($searchColum,'LIKE','%'.$searchText.'%')
     //                  ->paginate(10);
     //     return $task_catrgory;
    }
    public function fetchTaskCatrgoryByPage() {
      return $this->belongsTo(taskCategory::class, 'parent_id');
        // $task_catrgory = DB::select("SELECT t_c.*,(select name from task_category as t_c2 where t_c2.id = t_c.parent_id) as parent_name FROM task_category AS t_c LIMIT 10");
        // return $task_catrgory;
    }

    public function fetchTaskCatrgoryBySorting($sorted_colum, $data_sort_order) {
      return $this->belongsTo(taskCategory::class, 'parent_id');
        // $task_catrgory = taskCategory::orderBy($sorted_colum,$data_sort_order)
        //                ->paginate(10);
        // return $task_catrgory;
    }


    public function fetchTaskCategory() {
      return $this->belongsTo(taskCategory::class, 'parent_id');
      // $task_catrgory = DB::select("SELECT t_c.*,(select name from task_category as t_c2 where t_c2.id = t_c.parent_id) as parent_name FROM task_category AS t_c");
        // $task_catrgory =

        // DB::table('task_category')
        // //->join('task_category as subtask', 'task_category.id', '=', 'subtask.parent_id')
        // ->select('task_category.name as parentName')
        // ->get();
        // return $task_catrgory;
    }

    public function ActivefetchTaskCategory() {
      
      return $this->belongsTo(taskCategory::class, 'parent_id');
    }
    public function fetchTaskCatrgoryParent() {
      return $this->belongsTo(taskCategory::class, 'parent_id');
        // $task_catrgory = DB::select("SELECT * FROM `task_category` where parent_id IS NULL OR parent_id=0");
        // return $task_catrgory;
    }

}
