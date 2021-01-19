<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkforceNature extends Model
{
    use HasFactory;
    protected $table = 'workforce_nature';
    protected $fillable = [
        'name','is_active','status'
    ];
}
