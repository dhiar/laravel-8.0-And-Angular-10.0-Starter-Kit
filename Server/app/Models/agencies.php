<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class agencies extends Model
{
  use HasFactory;
  protected $table="agencies";
  protected $fillable=['agency_name','contacted_person','phone','first_email','second_email','is_active'];


  public function getcountry($id){
        // return $this->hasMany('App\Models\Country','id');
        $results=agencies::where('agencies.id',$id)->where('agencies.'.'is_active',1)->first();
        return $results;
  }
  public function fetchAgenciesForSearch($searchColum, $searchText) {
   $agencies =  DB::table('agencies');
   if ($searchColum == 'id'){
      $agencies->where('is_active',1)->where('agencies.'.$searchColum,$searchText);
    }else{
      $agencies->where('is_active',1)->where('agencies.'.$searchColum,'LIKE','%'.$searchText.'%');
    }
    $result = $agencies->paginate(config('paginateRecord'));
    return $result;
   // where('agencies.'. $searchColum,'LIKE','%'.$searchText.'%')
   // ->paginate(25);
   //     return $agencies;
  }
  public function fetchAgenciesByPage() {
      $agencies = agencies::where('is_active',1)->paginate(25);
      return $agencies;
  }

  public function fetchAgenciesBySorting($sorted_colum, $data_sort_order) {
      $agencies = agencies::where('is_active',1)->orderBy($sorted_colum,$data_sort_order)->paginate(25);
      return $agencies;
  }


  public function fetchAgencies() {
    $agencies=agencies::get();
    return $agencies;
   }

   public function ActivesfetchAgencies() {
     $agencies=agencies::where('agencies.'.'is_active',1)->get();
     return $agencies;
    }
}
