<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class currencies extends Model
{
    use HasFactory;
    protected $table="currencies";
    protected $fillable=['title','code','symbol','symbol_position','decimal_point','value','is_default','is_active'];



    public function fetchcurrenciesForSearch($searchColum, $searchText) {
     $currencies =  DB::table('currencies');
     if ($searchColum == 'id'){
         $currencies->where('currencies.'.$searchColum,$searchText);
      }else{
         $currencies->where('currencies.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $currencies->paginate(config('paginateRecord'));
      return $result;

     // where($searchColum,'LIKE','%'.$searchText.'%')
     //                  ->paginate(config('paginateRecord'));
     //     return $currencies;
    }
    public function fetchcurrenciesByPage() {
        $currencies = currencies::paginate(config('paginateRecord'));
        return $currencies;
    }

    public function fetchcurrenciesBySorting($sorted_colum, $data_sort_order) {
        $currencies = currencies::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $currencies;
    }


    public function fetchcurrencies() {
        $currencies = currencies::get();
        return $currencies;
    }
    public function actvfetchcurrencies() {
        $currencies = currencies::where('currencies.'.'is_active',1)->get();
        return $currencies;
    }
}
