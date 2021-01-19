<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
      'user_id','client_name','contact_person_name','company_name','email','country_code','is_active','email2','phone'
    ];
    public function getrecord($id){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('clients')
          ->leftjoin('users', 'users.id', '=', 'clients.user_id')
          ->select('clients.*','users.img','users.phone as user_phone','users.email as user_email','users.name as user_name','users.role_id')
          ->where('clients.id',$id)
          ->first();
          return $results;
    }
    public function fetchClientForSearch($searchColum, $searchText) {
     $Client =  DB::table('clients')
     ->leftjoin('users', 'users.id', '=', 'clients.user_id')
     ->select('clients.*','users.img',
     'users.phone as user_phone',
     'users.email as user_email',
     'users.name as user_name',
     'users.role_id');
     if ($searchColum == 'id'){
        $Client->where('clients.'.$searchColum,$searchText);
      }else{
        $Client->where('clients.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $Client->paginate(config('paginateRecord'));
      return $result;

     // ->where('clients.' . $searchColum,'LIKE','%'.$searchText.'%')
     // ->paginate(config('paginateRecord'));
     //     return $Client;
    }
    public function fetchClientByPage() {
        $Client = DB::table('clients')
        ->leftjoin('users', 'users.id', '=', 'clients.user_id')
        ->select('clients.*','users.img','users.phone as user_phone','users.email as user_email','users.name as user_name','users.role_id')
        ->paginate(config('paginateRecord'));
        return $Client;
    }

    public function fetchClientBySorting($sorted_colum, $data_sort_order) {
        $Client = DB::table('clients')
        ->leftjoin('users', 'users.id', '=', 'clients.user_id')
        ->select('clients.*','users.img','users.phone as user_phone','users.email as user_email','users.name as user_name','users.role_id')
        ->orderBy($sorted_colum,$data_sort_order)->paginate(config('paginateRecord'));
        return $Client;
    }

    public function fetchClient() {
        $Client = DB::table('clients')
        ->leftjoin('users', 'users.id', '=', 'clients.user_id')
        ->select('clients.*','users.img','users.phone as user_phone','users.email as user_email','users.name as user_name','users.role_id')
        ->get();
        return $Client;
    }
    public function ActivefetchClient() {
        $Client = DB::table('clients')
        ->leftjoin('users', 'users.id', '=', 'clients.user_id')
        ->select('clients.*','users.img','users.phone as user_phone','users.email as user_email','users.name as user_name','users.role_id')
        ->where('clients.'.'is_active',1)->get();
        return $Client;
    }
}
