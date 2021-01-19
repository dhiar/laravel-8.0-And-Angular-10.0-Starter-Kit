<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Manufacturers extends Model
{
    use HasFactory;
    protected $table="manufacturers";
    protected $fillable=['name','is_active','code'];
    public function fetchmanufacturersForSearch($searchColum, $searchText) {
     $Manufacturers =  DB::table('manufacturers');
     if ($searchColum == 'id'){
        $Manufacturers->where('manufacturers.'.$searchColum,$searchText);
      }else{
        $Manufacturers->where('manufacturers.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $Manufacturers->paginate(config('paginateRecord'));
      return $result;
     // where($searchColum,'LIKE','%'.$searchText.'%')
     //  ->paginate(config('paginateRecord'));
     //    return $Manufacturers;
    }
    public function fetchmanufacturersByPage() {
        $Manufacturers = Manufacturers::paginate(config('paginateRecord'));
        return $Manufacturers;
    }

    public function fetchmanufacturersBySorting($sorted_colum, $data_sort_order) {
        $Manufacturers = Manufacturers::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $Manufacturers;
    }


    public function fetchmanufacturers() {
        $Manufacturers = Manufacturers::get();
        return $Manufacturers;
    }
    public function actvfetchmanufacturers() {
        $Manufacturers = Manufacturers::where('manufacturers.'.'is_active',1)->get();
        return $Manufacturers;
    }
}
