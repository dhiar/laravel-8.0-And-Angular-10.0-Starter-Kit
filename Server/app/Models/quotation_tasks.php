<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotation_tasks extends Model
{
    use HasFactory;
    protected $table="quotation_tasks";
    protected $fillable=['task_id','quotation_id','per_houre_rate','task_code','description'];
}
