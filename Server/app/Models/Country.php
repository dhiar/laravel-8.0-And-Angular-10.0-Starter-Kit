<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Country extends Model
{
    public function fetchCountriesForSearch($searchColumn, $searchText) {
     $countries =   DB::table('countries');
     if ($searchColumn == 'id'){
           $countries->where('countries.'.$searchColumn,$searchText);
      }else{
        $countries->where('countries.'.$searchColumn,'LIKE','%'.$searchText.'%');
      }
      $result = $countries->paginate(config('paginateRecord'));
      return $result;
                      // ->where($searchColumn,'LIKE','%'.$searchText.'%')
                      // ->paginate(config('paginateRecord'));
         // return $countries;
    }

    public function fetchCountriesByPage() {
        $countries = DB::table('countries')->orderBy('id','DESC')->paginate(config('paginateRecord'));
        return $countries;
    }

    public function fetchCountriesBySorting($sorted_colum, $data_sort_order) {
        $countries = DB::table('countries')
                       ->orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $countries;
    }


    public function fetchCountries() {
        $countries = DB::table('countries')->orderBy('id','DESC')->get();
        return $countries;
    }
    public function actvfetchCountries() {
        $countries = DB::table('countries')->where('countries.'.'is_active',1)->orderBy('id','DESC')->get();
        return $countries;
    }
    public function getCountryById($id) {
        $country = DB::table('countries')->where('id',$id)->first();
        return $country;
    }

    public function insertGetId($request, $file_url) {
        $id = DB::table('countries')
                ->insertGetId([
                    'name' => $request->name,
                    'code' => $request->code,
                    'is_active' => $request->is_active,
                    'wrench_time' => $request->wrench_time,
                    'language_id' => $request->language_id,
                    'currency_id' => $request->currency_id,
                    'country_flag' => $file_url
                ]);
        return $id;
    }

    public function UpdateRecord($request, $file_url) {
        DB::table('countries')
        ->where('id',$request->id)
          ->update([
            'name' => $request->name,
            'code' => $request->code,
            'is_active' => $request->is_active,
            'country_flag' => $file_url,
            'wrench_time' => $request->wrench_time,
            'language_id' => $request->language_id,
            'currency_id' => $request->currency_id,
          ]);
        return 'success';
    }

    public function DeleteCountry($id) {
        DB::table('countries')->where('id', $id)->delete();
        return 'success';
    }

}
