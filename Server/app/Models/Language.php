<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Language extends Model
{
    public function fetchLanguagesForSearch($searchColumn, $searchText) {
     $languages =   DB::table('languages')
                               ->select('languages.*');
                               if ($searchColumn == 'id'){
                                     $languages->where('languages.'.$searchColumn,$searchText);
                                }else{
                                  $languages->where('languages.'.$searchColumn,'LIKE','%'.$searchText.'%');
                                }
                                $result = $languages->paginate(config('paginateRecord'));
                                return $result;
                      // ->where('languages.'. $searchColumn,'LIKE','%'.$searchText.'%')

                      // ->paginate(config('paginateRecord'));
         return $languages;
    }



    public function fetchLanguagesByPage() {
        $languages = DB::table('languages')
                    ->select(
                      'languages.*'
                      )
                    ->paginate(config('paginateRecord'));
        return $languages;
    }

    public function fetchLanguagesBySorting($sorted_colum, $data_sort_order) {
        $languages = DB::table('languages')
                       ->select(
                         'languages.*'
                         )
                       ->orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $languages;
    }

    public function fetchLanguages() {
        $languages = DB::table('languages')
                        ->select(
                          'languages.*'
                          )
                        ->get();
        return $languages;
    }

    public function actvfetchLanguages() {
        $languages = DB::table('languages')
                        ->select(
                          'languages.*'
                          )
                          ->where('languages.'.'is_active',1)
                        ->get();
        return $languages;
    }

     public function fetchLanguagesByCountry($id) {
        $languages = DB::table('languages')
                        ->where('country_id',$id)
                        ->select(
                          'languages.*'
                          )
                        ->get();
        return $languages;
    }

    public function getLanguageById($id) {
          $language = DB::table('languages')
                    ->where('languages.id',$id)
                    ->select(
                      'languages.*'
                      )
                    ->first();
        return $language;
    }

    public function insertGetId($request,$file_url) {


        $id = DB::table('languages')
                ->insertGetId([
                    'name' => $request->name,
                    'short_code' => $request->short_code,
                    'image' => $file_url,
                    'is_active' => $request->is_active,
                ]);
        return $id;
    }

    public function UpdateRecord($request,$file_url) {
        DB::table('languages')
        ->where('id',$request->id)
          ->update([
            'name' => $request->name,
            'short_code' => $request->short_code,
            'image' => $file_url,
            'is_active' => $request->is_active,
            'updated_at' => now()
          ]);
        return 'success';
    }

    public function DeleteLanguage($id) {
        DB::table('languages')->where('id', $id)->delete();
        return 'success';
    }

}
