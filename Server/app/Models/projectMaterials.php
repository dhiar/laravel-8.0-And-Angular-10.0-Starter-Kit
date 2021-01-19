<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectMaterials extends Model
{
    use HasFactory;
    protected $table="project_materials";
    protected $fillable=[
      'project_id','material_id','material_name','qty','price','vender_id','vender_name','is_active','currency_id','currency_name','Unit','distributor_no','Description','manufacture_id','manufacture_name','manufacture_no','sub_total'
    ];
}
