<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Site extends Model
{
    use HasFactory;
    protected $table = 'sites';
    protected $fillable = [
        'zone_id','client_id','name','city_id','state_id','country_id','latitude','longitude','radius','is_active'
    ];
    public function getrecord($id){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('sites')
          ->leftjoin('countries', 'countries.id', '=', 'sites.country_id')
          ->leftjoin('cities', 'cities.id', '=', 'sites.city_id')
          ->leftjoin('states', 'states.id', '=', 'sites.state_id')
          ->leftjoin('zones', 'zones.id', '=', 'sites.zone_id')
          ->select('countries.name as country_name','cities.name as city_name','states.name as state_name','sites.*','zones.name as zone_name')
          ->where('sites.id',$id)->first();
          return $results;
    }
    public function fetchSiteForSearch($searchColum, $searchText) {
     $Site =  DB::table('sites')
     ->leftjoin('countries', 'countries.id', '=', 'sites.country_id')
     ->leftjoin('cities', 'cities.id', '=', 'sites.city_id')
     ->leftjoin('states', 'states.id', '=', 'sites.state_id')
     ->leftjoin('zones', 'zones.id', '=', 'sites.zone_id')
     ->select('countries.name as country_name',
     'cities.name as city_name',
     'states.name as state_name',
     'sites.*','zones.name as zone_name');
     if ($searchColum == 'id'){
           $Site->where('sites.'.$searchColum,$searchText);
      }else{
        $Site->where('sites.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $Site->paginate(config('paginateRecord'));
      return $result;
     // ->where('sites.'. $searchColum,'LIKE','%'.$searchText.'%')
     // ->paginate(config('paginateRecord'));
     // return $Site;
    }
    public function fetchSiteByPage() {
        $Site = DB::table('sites')
        ->leftjoin('countries', 'countries.id', '=', 'sites.country_id')
        ->leftjoin('cities', 'cities.id', '=', 'sites.city_id')
        ->leftjoin('states', 'states.id', '=', 'sites.state_id')
        ->leftjoin('zones', 'zones.id', '=', 'sites.zone_id')
        ->select('countries.name as country_name','cities.name as city_name','states.name as state_name','sites.*','zones.name as zone_name')
        ->paginate(config('paginateRecord'));
        return $Site;
    }

    public function fetchSiteBySorting($sorted_colum, $data_sort_order) {
        $Site = DB::table('sites')
        ->leftjoin('countries', 'countries.id', '=', 'sites.country_id')
        ->leftjoin('cities', 'cities.id', '=', 'sites.city_id')
        ->leftjoin('states', 'states.id', '=', 'sites.state_id')
        ->leftjoin('zones', 'zones.id', '=', 'sites.zone_id')
        ->select('countries.name as country_name','cities.name as city_name','states.name as state_name','sites.*','zones.name as zone_name')
        ->orderBy($sorted_colum,$data_sort_order)->paginate(config('paginateRecord'));
        return $Site;
    }

    public function fetchSite() {
        $Site = DB::table('sites')
        ->leftjoin('countries', 'countries.id', '=', 'sites.country_id')
        ->leftjoin('cities', 'cities.id', '=', 'sites.city_id')
        ->leftjoin('states', 'states.id', '=', 'sites.state_id')
        ->leftjoin('zones', 'zones.id', '=', 'sites.zone_id')
        ->select('countries.name as country_name','cities.name as city_name','states.name as state_name','sites.*','zones.name as zone_name')
        ->get();
        return $Site;
    }

    public function actvfetchSite() {
        $Site = DB::table('sites')
        ->leftjoin('countries', 'countries.id', '=', 'sites.country_id')
        ->leftjoin('cities', 'cities.id', '=', 'sites.city_id')
        ->leftjoin('states', 'states.id', '=', 'sites.state_id')
        ->leftjoin('zones', 'zones.id', '=', 'sites.zone_id')
        ->select('countries.name as country_name','cities.name as city_name','states.name as state_name','sites.*','zones.name as zone_name')
        ->where('sites.'.'is_active',1)->get();
        return $Site;
    }
}
