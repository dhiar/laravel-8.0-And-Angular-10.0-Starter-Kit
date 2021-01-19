<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class State extends Model
{
    public function fetchStatesForSearch($searchColumn, $searchText) {
     $states =   DB::table('states')
                      ->leftJoin('countries','states.country_id','countries.id')
                        ->select('states.*','countries.name as country_name');
                        if ($searchColumn == 'id'){
                              $states->where('states.'.$searchColumn,$searchText);
                         }else{
                           $states->where('states.'.$searchColumn,'LIKE','%'.$searchText.'%');
                         }
                         $result = $states->paginate(config('paginateRecord'));
                         return $result;
         //              ->where('states.'. $searchColumn,'LIKE','%'.$searchText.'%')
         //
         //              ->paginate(config('paginateRecord'));
         // return $states;
    }

    public function fetchStatesByPage() {
        $states = DB::table('states')
                    ->leftJoin('countries','states.country_id','countries.id')
                    ->select('states.*','countries.name as country_name')
                    ->paginate(config('paginateRecord'));
        return $states;
    }

    public function fetchStatesBySorting($sorted_colum, $data_sort_order) {
        $states = DB::table('states')
                       ->leftJoin('countries','states.country_id','countries.id')
                       ->select('states.*','countries.name as country_name')
                       ->orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $states;
    }

    public function fetchStates() {
        $states = DB::table('states')->get();
        return $states;
    }

    public function actvfetchStates() {
        $states = DB::table('states')->where('states.'.'is_active',1)->get();
        return $states;
    }
    public function getStateById($id) {
          $state = DB::table('states')
                    ->leftJoin('countries','states.country_id','countries.id')
                    ->where('states.id',$id)
                    ->select('states.*','countries.name as country_name')
                    ->first();
        return $state;
    }

    public function getStatesByCountry($id) {
        $states = DB::table('states')->where('country_id',$id)->get();
        return $states;
    }

    public function insertGetId($request) {
        $id = DB::table('states')
                ->insertGetId([
                    'name' => $request->name,
                    'is_active' => $request->status,
                    'country_id' => $request->country_id
                ]);
        return $id;
    }

    public function UpdateRecord($request) {
        DB::table('states')
        ->where('id',$request->id)
          ->update([
            'name' => $request->name,
            'is_active' => $request->status,
            'country_id' => $request->country_id,
            'updated_at' => now()
          ]);
        return 'success';
    }

    public function DeleteState($id) {
        DB::table('states')->where('id', $id)->delete();
        return 'success';
    }

}
