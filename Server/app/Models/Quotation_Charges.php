<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation_Charges extends Model
{
    use HasFactory;
    protected $table="quotations_additional_charges";
    protected $fillable=['price','description','quotation_id'];
}
