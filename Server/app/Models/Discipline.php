<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;
    protected $table = 'discipline';
    protected $fillable = [
        'name','is_active','status'
    ];

    public function fetchDisciplineForSearch($searchColum, $searchText) {
     $Discipline =  Discipline::where($searchColum,'LIKE','%'.$searchText.'%')
                      ->paginate(config('paginateRecord'));
         return $Discipline;
    }
    public function fetchDisciplineByPage() {
        $Discipline = Discipline::paginate(config('paginateRecord'));
        return $Discipline;
    }

    public function fetchDisciplineBySorting($sorted_colum, $data_sort_order) {
        $Discipline = Discipline::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $Discipline;
    }

    public function fetchDiscipline() {
        $Discipline = Discipline::get();
        return $Discipline;
    }
}
