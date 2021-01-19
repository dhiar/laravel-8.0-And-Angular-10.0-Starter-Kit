<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotation_tasks_assignee extends Model
{
    use HasFactory;
    protected $table="quotation_tasks_assignee";
    protected $fillable=['quotation_id','workforce_id','price','alot_time','time_type'];
}
