<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class unit extends Model
{
    use HasFactory;
    protected $table="unit";
    protected $fillable=['type','is_active'];
    public function fetchUnitForSearch($searchColum, $searchText) {
     $unit =  DB::table('unit');
     if ($searchColum == 'id'){
        $unit->where('unit.'.$searchColum,$searchText);
      }else{
        $unit->where('unit.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $unit->paginate(config('paginateRecord'));
      return $result;
     // where($searchColum,'LIKE','%'.$searchText.'%')
     //  ->paginate(config('paginateRecord'));
     //     return $unit;
    }
    public function fetchUnitByPage() {
        $unit = unit::paginate(config('paginateRecord'));
        return $unit;
    }

    public function fetchUnitBySorting($sorted_colum, $data_sort_order) {
        $unit = unit::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $unit;
    }


    public function fetchUnit() {
        $unit = unit::get();
        return $unit;
    }
    public function actvfetchUnit() {
        $unit = unit::where('unit.'.'is_active',1)->get();
        return $unit;
    }
}
