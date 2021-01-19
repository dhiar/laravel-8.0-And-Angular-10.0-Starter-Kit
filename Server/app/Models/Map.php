<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Map extends Model
{
    public function getCords($id) {
     $cords =   DB::table('zones')
                  ->leftJoin('countries','zones.country_id','countries.id')
                  ->leftJoin('states','zones.state_id','states.id')
                  ->leftJoin('cities','zones.city_id','cities.id')
                  ->select('zones.*',
                           'countries.name as country_name',
                           'countries.code as country_code',
                           'states.name as state_name',
                           'cities.name as city_name'
                           )
                  ->where('zones.id',$id)
                  ->first();
         return $cords;
    }

    public function updateCords($id,$coords) {
                 DB::table('zones')
                  ->where('id',$id)
                  ->update([
                    'coordinates' => $coords,
                  ]);
         return 'success';
    }

}
