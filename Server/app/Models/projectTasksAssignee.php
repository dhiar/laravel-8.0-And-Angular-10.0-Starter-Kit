<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectTasksAssignee extends Model
{
    use HasFactory;
    protected $table="project_tasks_assignee";
    protected $fillable=['project_id','workforce_id','price','alot_time','time_type'];
}
