<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotations_Materials extends Model
{
    use HasFactory;
    protected $table="quotations_materials";
    protected $fillable=[
      'quotation_id','material_id','material_name','qty','price','vender_id','vender_name','is_active','currency_id','currency_name','Unit','distributor_no','Description','manufacture_id','manufacture_name','manufacture_no','sub_total'
    ];



}
