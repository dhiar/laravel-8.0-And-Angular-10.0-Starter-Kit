<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DB;
class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'users';
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'role_id',
        'first_email',
        'second_email',
        'country',
        'city',
        'state',
        'phone',
        'img',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getrecord($id){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('users')
          ->leftjoin('countries', 'countries.id', '=', 'users.country')
          ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
          ->leftjoin('cities', 'cities.id', '=', 'users.city')
          ->leftjoin('states', 'states.id', '=', 'users.state')
          ->select('countries.name as country_name','roles.name as role_name','users.*','cities.name as city_name','states.name as state_name')
          ->where('users.id',$id)->first();
          return $results;
    }
    public function fetchUserForSearch($searchColum, $searchText) {
     $User =  DB::table('users')
     ->leftjoin('countries', 'countries.id', '=', 'users.country')
     ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
     ->leftjoin('cities', 'cities.id', '=', 'users.city')
     ->leftjoin('states', 'states.id', '=', 'users.state')
     ->select('countries.name as country_name','roles.name as role_name','users.*','cities.name as city_name','states.name as state_name')
     ->where('users.' . $searchColum,'LIKE','%'.$searchText.'%')
     ->paginate(config('paginateRecord'));
         return $User;
    }
    public function fetchUserByPage() {
        $User = DB::table('users')
        ->leftjoin('countries', 'countries.id', '=', 'users.country')
        ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
        ->leftjoin('cities', 'cities.id', '=', 'users.city')
        ->leftjoin('states', 'states.id', '=', 'users.state')
        ->select('countries.name as country_name','roles.name as role_name','users.*','cities.name as city_name','states.name as state_name')
        ->paginate(config('paginateRecord'));
        return $User;
    }

    public function fetchUserBySorting($sorted_colum, $data_sort_order) {
        // $User = User::orderBy($sorted_colum,$data_sort_order)
        //                ->paginate(config('paginateRecord'));
        $User = DB::table('users')
        ->leftjoin('countries', 'countries.id', '=', 'users.country')
        ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
        ->leftjoin('cities', 'cities.id', '=', 'users.city')
        ->leftjoin('states', 'states.id', '=', 'users.state')
        ->select('countries.name as country_name','roles.name as role_name','users.*','cities.name as city_name','states.name as state_name')
        ->orderBy($sorted_colum,$data_sort_order)
        ->paginate(config('paginateRecord'));
        return $User;
    }


    public function fetchUser() {
        $User = DB::table('users')
        ->leftjoin('countries', 'countries.id', '=', 'users.country')
        ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
        ->leftjoin('cities', 'cities.id', '=', 'users.city')
        ->leftjoin('states', 'states.id', '=', 'users.state')
        ->select('countries.name as country_name','roles.name as role_name','users.*','cities.name as city_name','states.name as state_name')
        ->get();
        return $User;
    }
}
