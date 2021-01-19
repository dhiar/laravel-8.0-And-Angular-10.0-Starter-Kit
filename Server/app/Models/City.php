<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class City extends Model
{
    public function fetchCitiesForSearch($searchColumn, $searchText) {
     $cities =   DB::table('cities')
                      ->leftJoin('states','cities.state_id','states.id')
                      ->leftJoin('countries','cities.country_id','countries.id')
                      ->select('cities.*','countries.name as country_name','states.name as state_name');
                      if ($searchColumn == 'id'){
                            $cities->where('cities.'.$searchColumn,$searchText);
                       }else{
                         $cities->where('cities.'.$searchColumn,'LIKE','%'.$searchText.'%');
                       }
                       $result = $cities->paginate(config('paginateRecord'));
                       return $result;
         //              ->where('cities.'. $searchColumn,'LIKE','%'.$searchText.'%')
         //
         //              ->paginate(config('paginateRecord'));
         // return $cities;
    }

    public function fetchCitiesByPage() {
        $cities = DB::table('cities')
                    ->leftJoin('states','cities.state_id','states.id')
                    ->leftJoin('countries','cities.country_id','countries.id')
                    ->select('cities.*','countries.name as country_name','states.name as state_name')
                    ->paginate(config('paginateRecord'));
        return $cities;
    }

    public function fetchCitiesBySorting($sorted_colum, $data_sort_order) {
        $cities = DB::table('cities')
                       ->leftJoin('states','cities.state_id','states.id')
                       ->leftJoin('countries','cities.country_id','countries.id')
                       ->select('cities.*','countries.name as country_name','states.name as state_name')
                       ->orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $cities;
    }

    public function fetchCities() {
        $cities = DB::table('cities')->get();
        return $cities;
    }
    public function actvfetchCities() {
        $cities = DB::table('cities')->where('cities'.'is_active',1)->get();
        return $cities;
    }
    public function fetchCitiesByState($id) {
        $cities = DB::table('cities')->where('state_id',$id)->get();
        return $cities;
    }

     public function fetchCitiesByCountry($id) {
        $cities = DB::table('cities')->where('country_id',$id)->get();
        return $cities;
    }

    public function getCityById($id) {
          $city = DB::table('cities')
                    ->leftJoin('states','cities.state_id','states.id')
                    ->leftJoin('countries','cities.country_id','countries.id')
                    ->where('cities.id',$id)
                    ->select('cities.*','countries.name as country_name','states.name as state_name')
                    ->first();
        return $city;
    }

    public function insertGetId($request) {
        $id = DB::table('cities')
                ->insertGetId([
                    'name' => $request->name,
                    'is_active' => $request->status,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id

                ]);
        return $id;
    }

    public function UpdateRecord($request) {
        DB::table('cities')
        ->where('id',$request->id)
          ->update([
            'name' => $request->name,
            'is_active' => $request->status,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'updated_at' => now()
          ]);
        return 'success';
    }

    public function DeleteCity($id) {
        DB::table('cities')->where('id', $id)->delete();
        return 'success';
    }

}
