<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class employee_detail extends Model
{
    use HasFactory;
    protected $table="employee_detail";
    protected $fillable=['category_id','wrench_time','zone_id','agency_id','employee_type'];

    public function getrecord($id){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('employee_detail')
          ->leftjoin('zones', 'zones.id', '=', 'employee_detail.zone_id')
          ->leftjoin('agencies', 'agencies.id', '=', 'employee_detail.agency_id')
          ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'employee_detail.category_id')
          ->leftjoin('users', 'users.id', '=', 'employee_detail.user_id')
          ->select('zones.name as zone_name','users.*','workforce_nature.name as workroll_name','employee_detail.*','agencies.agency_name as agency_name')
          ->where('employee_detail.id',$id)->first();
          return $results;
    }

    public function fetchEmployeeDetailForSearch($searchColum, $searchText) {
     $employee_detail =  DB::table('employee_detail')
     ->leftjoin('zones', 'zones.id', '=', 'employee_detail.zone_id')
     ->leftjoin('agencies', 'agencies.id', '=', 'employee_detail.agency_id')
     ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'employee_detail.category_id')
     ->leftjoin('users', 'users.id', '=', 'employee_detail.user_id')
     ->select('zones.name as zone_name','users.*','workforce_nature.name as workroll_name','employee_detail.*','agencies.agency_name as agency_name')
     ->where('employee_detail.' . $searchColum,'LIKE','%'.$searchText.'%')
     ->paginate(config('paginateRecord'));
         return $employee_detail;
    }
    public function fetchEmployeeDetailByPage() {
        $employee_detail = DB::table('employee_detail')
        ->leftjoin('zones', 'zones.id', '=', 'employee_detail.zone_id')
        ->leftjoin('agencies', 'agencies.id', '=', 'employee_detail.agency_id')
        ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'employee_detail.category_id')
        ->leftjoin('users', 'users.id', '=', 'employee_detail.user_id')
        ->select('zones.name as zone_name','users.*','workforce_nature.name as workroll_name','employee_detail.*','agencies.agency_name as agency_name')
        ->paginate(config('paginateRecord'));
        return $employee_detail;
    }

    public function fetchEmployeeDetailBySorting($sorted_colum, $data_sort_order) {
        $employee_detail = DB::table('employee_detail')
        ->leftjoin('zones', 'zones.id', '=', 'employee_detail.zone_id')
        ->leftjoin('agencies', 'agencies.id', '=', 'employee_detail.agency_id')
        ->leftjoin('workforce_nature', 'workforce_nature.id', '=', 'employee_detail.category_id')
        ->leftjoin('users', 'users.id', '=', 'employee_detail.user_id')
        ->select('zones.name as zone_name','users.*','workforce_nature.name as workroll_name','employee_detail.*','agencies.agency_name as agency_name')
        ->orderBy($sorted_colum,$data_sort_order)->paginate(config('paginateRecord'));
        return $employee_detail;
    }


    public function fetchEmployeeDetail() {
        $employee_detail = DB::table('employee_detail')
        ->leftjoin('zones', 'zones.id', '=', 'employee_detail.zone_id')
        ->leftjoin('agencies', 'agencies.id', '=', 'employee_detail.agency_id')
        ->leftjoin('work_roles', 'work_roles.id', '=', 'employee_detail.category_id')
        ->leftjoin('users', 'users.id', '=', 'employee_detail.user_id')
        ->select('zones.name as zone_name','users.*','work_roles.name as workroll_name','employee_detail.*','agencies.agency_name as agency_name')
        ->get();
        return $employee_detail;
    }
}
