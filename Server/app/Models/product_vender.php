<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class product_vender extends Model
{
    use HasFactory;
    protected $table="product_vender";
    protected $fillable=['vender_name','code','vender_first_email','vender_second_email','phone','address','country_id','city','state','common_id'];

    public function getrecord($id){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('product_vender')
          ->leftjoin('countries', 'countries.id', '=', 'product_vender.country_id')
          ->leftjoin('cities', 'cities.id', '=', 'product_vender.city')
          ->leftjoin('states', 'states.id', '=', 'product_vender.state')
          ->leftjoin('common_distributor', 'common_distributor.id', '=', 'product_vender.common_id')
          ->select('common_distributor.name as CommonName','countries.name as country_name','cities.name as city_name','states.name as state_name','product_vender.*')
          ->where('product_vender.id',$id)->first();
          return $results;
    }

    public function fetchProductVenderForSearch($searchColum, $searchText) {
     $product_vender =  DB::table('product_vender')
     ->leftjoin('countries', 'countries.id', '=', 'product_vender.country_id')
     ->leftjoin('cities', 'cities.id', '=', 'product_vender.city')
     ->leftjoin('states', 'states.id', '=', 'product_vender.state')
     ->leftjoin('common_distributor', 'common_distributor.id', '=', 'product_vender.common_id')
     ->select('common_distributor.name as CommonName',
     'countries.name as country_name',
     'cities.name as city_name',
     'states.name as state_name',
     'product_vender.*');
     if ($searchColum == 'id'){
        $product_vender->where('product_vender.'.$searchColum,$searchText);
      }else{
        $product_vender->where('product_vender.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $product_vender->paginate(config('paginateRecord'));
      return $result;
     // ->where('product_vender.'. $searchColum,'LIKE','%'.$searchText.'%')
     // ->paginate(config('paginateRecord'));
     //  return $product_vender;
    }
    public function fetchProductVenderByPage() {
        $product_vender =DB::table('product_vender')
        ->leftjoin('countries', 'countries.id', '=', 'product_vender.country_id')
        ->leftjoin('cities', 'cities.id', '=', 'product_vender.city')
        ->leftjoin('states', 'states.id', '=', 'product_vender.state')
        ->leftjoin('common_distributor', 'common_distributor.id', '=', 'product_vender.common_id')
        ->select('common_distributor.name as CommonName','countries.name as country_name','cities.name as city_name','states.name as state_name','product_vender.*')
        ->paginate(config('paginateRecord'));
        return $product_vender;
    }

    public function fetchProductVenderBySorting($sorted_colum, $data_sort_order) {
        $product_vender = DB::table('product_vender')
        ->leftjoin('countries', 'countries.id', '=', 'product_vender.country_id')
        ->leftjoin('cities', 'cities.id', '=', 'product_vender.city')
        ->leftjoin('states', 'states.id', '=', 'product_vender.state')
        ->leftjoin('common_distributor', 'common_distributor.id', '=', 'product_vender.common_id')
        ->select('common_distributor.name as CommonName','countries.name as country_name','cities.name as city_name','states.name as state_name','product_vender.*')
        ->orderBy($sorted_colum,$data_sort_order)
        ->paginate(config('paginateRecord'));
        return $product_vender;
    }

    public function fetchProductVender() {
        $product_vender = DB::table('product_vender')
        ->leftjoin('countries', 'countries.id', '=', 'product_vender.country_id')
        ->leftjoin('cities', 'cities.id', '=', 'product_vender.city')
        ->leftjoin('states', 'states.id', '=', 'product_vender.state')
        ->leftjoin('common_distributor', 'common_distributor.id', '=', 'product_vender.common_id')
        ->select('common_distributor.name as CommonName','countries.name as country_name','cities.name as city_name','states.name as state_name','product_vender.*')
        ->get();
        return $product_vender;
    }

    public function actvfetchProductVender() {
        $product_vender = DB::table('product_vender')
        ->leftjoin('countries', 'countries.id', '=', 'product_vender.country_id')
        ->leftjoin('cities', 'cities.id', '=', 'product_vender.city')
        ->leftjoin('states', 'states.id', '=', 'product_vender.state')
        ->leftjoin('common_distributor', 'common_distributor.id', '=', 'product_vender.common_id')
        ->select('common_distributor.name as CommonName','countries.name as country_name','cities.name as city_name','states.name as state_name','product_vender.*')
        ->where('product_vender.'.'is_active',1)->get();
        return $product_vender;
    }
}
