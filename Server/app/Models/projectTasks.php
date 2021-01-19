<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectTasks extends Model
{
    use HasFactory;
    protected $table="project_tasks";
    protected $fillable=['task_id','project_id','per_houre_rate','task_code','description'];

}
