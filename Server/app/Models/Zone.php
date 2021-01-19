<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Zone extends Model
{
    public function fetchZonesForSearch($searchColumn, $searchText) {
     $Zones =   DB::table('zones')
     ->leftJoin('cities','zones.city_id','cities.id')
     ->leftJoin('states','zones.state_id','states.id')
     ->leftJoin('countries','zones.country_id','countries.id')
     ->select('zones.*','cities.name as city_name',
     'states.name as state_name','countries.name as country_name');
     if ($searchColumn == 'id'){
           $Zones->where('zones.'.$searchColumn,$searchText);
      }else{
        $Zones->where('zones.'.$searchColumn,'LIKE','%'.$searchText.'%');
      }
     // ->where('zones.'. $searchColumn,'LIKE','%'.$searchText.'%')
     $result = $Zones->paginate(config('paginateRecord'));
     return $result;
     // ->paginate(config('paginateRecord'));
     // return $Zones;
    }

    public function fetchZonesByPage() {
        $Zones = DB::table('zones')
                  ->leftJoin('cities','zones.city_id','cities.id')
                  ->leftJoin('states','zones.state_id','states.id')
                  ->leftJoin('countries','zones.country_id','countries.id')
                  ->select('zones.*','cities.name as city_name','states.name as state_name','countries.name as country_name')
                  ->paginate(config('paginateRecord'));
        return $Zones;
    }

    public function fetchZonesBySorting($sorted_colum, $data_sort_order) {
        $Zones = DB::table('zones')
        ->leftJoin('cities','zones.city_id','cities.id')
        ->leftJoin('states','zones.state_id','states.id')
        ->leftJoin('countries','zones.country_id','countries.id')
        ->select('zones.*','cities.name as city_name','states.name as state_name','countries.name as country_name')
        ->orderBy($sorted_colum,$data_sort_order)
        ->paginate(config('paginateRecord'));
        return $Zones;
    }


    public function fetchZones() {
        $Zones = DB::table('zones')
        ->leftJoin('cities','zones.city_id','cities.id')
        ->leftJoin('states','zones.state_id','states.id')
        ->leftJoin('countries','zones.country_id','countries.id')
        ->select('zones.*','cities.name as city_name','states.name as state_name','countries.name as country_name')
        ->get();
        return $Zones;
    }

    public function actvfetchZones() {
        $Zones = DB::table('zones')
        ->leftJoin('cities','zones.city_id','cities.id')
        ->leftJoin('states','zones.state_id','states.id')
        ->leftJoin('countries','zones.country_id','countries.id')
        ->select('zones.*','cities.name as city_name','states.name as state_name','countries.name as country_name')
        ->where('zones.'.'is_active',1)->get();
        return $Zones;
    }

    public function getZoneById($id) {
        $Zone = DB::table('zones')
        ->leftJoin('cities','zones.city_id','cities.id')
        ->leftJoin('states','zones.state_id','states.id')
        ->leftJoin('countries','zones.country_id','countries.id')
        ->select('zones.*','cities.name as city_name','states.name as state_name','countries.name as country_name')
        ->where('zones.id',$id)
        ->first();
        return $Zone;
    }

    public function insertGetId($request) {
        $id = DB::table('zones')
                ->insertGetId([
                    'name' => $request->name,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'is_active' => $request->status,
                ]);
        return $id;
    }

    public function UpdateRecord($request) {
        DB::table('zones')
        ->where('id',$request->id)
          ->update([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'is_active' => $request->status,
            'updated_at' => now()
          ]);
        return 'success';
    }

    public function DeleteZone($id) {
        DB::table('zones')->where('id', $id)->delete();
        return 'success';
    }

}
