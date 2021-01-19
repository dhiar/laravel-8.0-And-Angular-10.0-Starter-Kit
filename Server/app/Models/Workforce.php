<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Workforce extends Model
{
    use HasFactory;
    protected $table = 'work_force';
    protected $fillable = [
        'job_nature_id','category_id','country_code','zone_id','employee_name','country','city','phone','email','agency','state','email2','discipline_id','user_id'
    ];

    public function getrecord($id){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('work_force')
          ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'work_force.job_nature_id')
          ->leftjoin('workforce_category', 'workforce_category.id', '=', 'work_force.category_id')
          ->leftjoin('zones', 'zones.id', '=', 'work_force.zone_id')
          ->leftjoin('countries', 'countries.id', '=', 'work_force.country')
          ->leftjoin('agencies', 'agencies.id', '=', 'work_force.agency')
          ->leftjoin('states', 'states.id', '=', 'work_force.state')
          ->leftjoin('cities', 'cities.id', '=', 'work_force.city')
          ->leftjoin('users', 'users.id', '=', 'work_force.user_id')
          ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'work_force.discipline_id')
          ->select('users.name as UserName','workforce_decipline.name as WorkforceDeciplineName','workforce_category.name as workCategoryName','workforce_nature.name as workforce_nature_name','work_force.*','zones.name as zone_name','countries.name as country_name','agencies.agency_name as agency_name','states.name as state_name','cities.name as cityName')
          ->where('work_force.id',$id)->first();
          return $results;
    }

    public function getrecordByUserId($uid){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('work_force')
          ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'work_force.job_nature_id')
          ->leftjoin('workforce_category', 'workforce_category.id', '=', 'work_force.category_id')
          ->leftjoin('zones', 'zones.id', '=', 'work_force.zone_id')
          ->leftjoin('countries', 'countries.id', '=', 'work_force.country')
          ->leftjoin('agencies', 'agencies.id', '=', 'work_force.agency')
          ->leftjoin('states', 'states.id', '=', 'work_force.state')
          ->leftjoin('cities', 'cities.id', '=', 'work_force.city')
          ->leftjoin('users', 'users.id', '=', 'work_force.user_id')
          ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'work_force.discipline_id')
          ->select('users.name as UserName','workforce_decipline.name as WorkforceDeciplineName','workforce_category.name as workCategoryName','workforce_nature.name as workforce_nature_name','work_force.*','zones.name as zone_name','countries.name as country_name','agencies.agency_name as agency_name','states.name as state_name','cities.name as cityName')
          ->where('work_force.user_id',$uid)->get();
          return $results;
    }


    public function fetchWorkForceForSearch($searchColum, $searchText) {
     $Workforce =DB::table('work_force')
     ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'work_force.job_nature_id')
     ->leftjoin('workforce_category', 'workforce_category.id', '=', 'work_force.category_id')
     ->leftjoin('zones', 'zones.id', '=', 'work_force.zone_id')
     ->leftjoin('countries', 'countries.id', '=', 'work_force.country')
     ->leftjoin('agencies', 'agencies.id', '=', 'work_force.agency')
     ->leftjoin('states', 'states.id', '=', 'work_force.state')
     ->leftjoin('cities', 'cities.id', '=', 'work_force.city')
     ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'work_force.discipline_id')
     ->select('workforce_decipline.name as WorkforceDeciplineName',
     'workforce_category.name as workCategoryName',
     'workforce_nature.name as workforce_nature_name',
     'work_force.*','zones.name as zone_name',
     'countries.name as country_name',
     'agencies.agency_name as agency_name',
     'states.name as state_name','cities.name as cityName');
     if ($searchColum == 'id'){
        $Workforce->where('work_force.'.$searchColum,$searchText);
      }else{
        $Workforce->where('work_force.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $Workforce->paginate(config('paginateRecord'));
      return $result;
     // ->where('work_force.'. $searchColum,'LIKE','%'.$searchText.'%')
     // ->paginate(config('paginateRecord'));
     //     return $Workforce;
    }
    public function fetchWorkForceByPage() {
        $Workforce = DB::table('work_force')
        ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'work_force.job_nature_id')
        ->leftjoin('workforce_category', 'workforce_category.id', '=', 'work_force.category_id')
        ->leftjoin('zones', 'zones.id', '=', 'work_force.zone_id')
        ->leftjoin('countries', 'countries.id', '=', 'work_force.country')
        ->leftjoin('agencies', 'agencies.id', '=', 'work_force.agency')
        ->leftjoin('states', 'states.id', '=', 'work_force.state')
        ->leftjoin('cities', 'cities.id', '=', 'work_force.city')
        ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'work_force.discipline_id')
        ->select('workforce_decipline.name as WorkforceDeciplineName','workforce_category.name as workCategoryName','workforce_nature.name as workforce_nature_name','work_force.*','zones.name as zone_name','countries.name as country_name','agencies.agency_name as agency_name','states.name as state_name','cities.name as cityName')
        ->paginate(config('paginateRecord'));
        return $Workforce;
    }

    public function fetchWorkForceBySorting($sorted_colum, $data_sort_order) {
        $Workforce = DB::table('work_force')
        ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'work_force.job_nature_id')
        ->leftjoin('workforce_category', 'workforce_category.id', '=', 'work_force.category_id')
        ->leftjoin('zones', 'zones.id', '=', 'work_force.zone_id')
        ->leftjoin('countries', 'countries.id', '=', 'work_force.country')
        ->leftjoin('agencies', 'agencies.id', '=', 'work_force.agency')
        ->leftjoin('states', 'states.id', '=', 'work_force.state')
        ->leftjoin('cities', 'cities.id', '=', 'work_force.city')
        ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'work_force.discipline_id')
        ->select('workforce_decipline.name as WorkforceDeciplineName','workforce_category.name as workCategoryName','workforce_nature.name as workforce_nature_name','work_force.*','zones.name as zone_name','countries.name as country_name','agencies.agency_name as agency_name','states.name as state_name','cities.name as cityName')
        ->orderBy($sorted_colum,$data_sort_order)->paginate(config('paginateRecord'));
        return $Workforce;
    }

    public function fetchWorkForce() {
        $Workforce =   DB::table('work_force')
        ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'work_force.job_nature_id')
        ->leftjoin('workforce_category', 'workforce_category.id', '=', 'work_force.category_id')
        ->leftjoin('zones', 'zones.id', '=', 'work_force.zone_id')
        ->leftjoin('countries', 'countries.id', '=', 'work_force.country')
        ->leftjoin('agencies', 'agencies.id', '=', 'work_force.agency')
        ->leftjoin('states', 'states.id', '=', 'work_force.state')
        ->leftjoin('cities', 'cities.id', '=', 'work_force.city')
        ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'work_force.discipline_id')
        ->select('workforce_decipline.name as WorkforceDeciplineName','workforce_category.name as workCategoryName','workforce_nature.name as workforce_nature_name','work_force.*','zones.name as zone_name','countries.name as country_name','agencies.agency_name as agency_name','states.name as state_name','cities.name as cityName')
        ->get();
        return $Workforce;
    }

    public function ActivefetchWorkForce() {
        $Workforce =   DB::table('work_force')
        ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'work_force.job_nature_id')
        ->leftjoin('workforce_category', 'workforce_category.id', '=', 'work_force.category_id')
        ->leftjoin('zones', 'zones.id', '=', 'work_force.zone_id')
        ->leftjoin('countries', 'countries.id', '=', 'work_force.country')
        ->leftjoin('agencies', 'agencies.id', '=', 'work_force.agency')
        ->leftjoin('states', 'states.id', '=', 'work_force.state')
        ->leftjoin('cities', 'cities.id', '=', 'work_force.city')
        ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'work_force.discipline_id')
        ->select('workforce_decipline.name as WorkforceDeciplineName','workforce_category.name as workCategoryName','workforce_nature.name as workforce_nature_name','work_force.*','zones.name as zone_name','countries.name as country_name','agencies.agency_name as agency_name','states.name as state_name','cities.name as cityName')
        ->where('work_force.'.'is_active',1)->get();
        return $Workforce;
    }
    //
    // ->leftjoin('workforce_category', 'workforce_category.id', '=', 'work_force.	category_id')
    //
    // ->leftjoin('cities', 'cities.id', '=', 'work_force.city')
    //
    // ->get();
}
