<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_category extends Model
{
    use HasFactory;
    protected $table="product_category";
    protected $fillable=['vender_name','vender_first_email','vender_second_email'];
}
