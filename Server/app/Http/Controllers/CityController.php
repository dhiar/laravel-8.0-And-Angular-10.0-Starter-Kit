<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\City;
use App\Models\Country;
use DB;

class CityController extends Controller
{
    public function __construct(City $city, Country $country)
    {
      $this->city = $city;
      $this->country = $country;
    }

    public function fetchCities(Request $request) {
        if($request->searchText){
            $cities = $this->city->fetchCitiesForSearch($request->searchColumn,$request->searchText);
            return response()->json($cities);
        }
        if($request->page && !$request->data_sort_order){
            $cities = $this->city->fetchCitiesByPage();
            return response()->json($cities);
        }
        else if($request->data_sort_order){
            $cities = $this->city->fetchCitiesBySorting($request->sorted_colum,$request->data_sort_order);
            return response()->json($cities);
        }
        $cities = $this->city->fetchCities();
        return response()->json($cities);

    }

    public function activefetchCities(){
      $cities = $this->city->actvfetchCities();
      return response()->json($cities);
    }

    public function getCityById(Request $request, $id) {
       $city =  $this->city->getCityById($id);
       return response()->json($city);
    }

    public function fetchCitiesByState(Request $request, $id) {
        $cities =  $this->city->fetchCitiesByState($id);
        return response()->json($cities);
    }

     public function fetchCitiesByCountry(Request $request, $id) {
        $cities =  $this->city->fetchCitiesByCountry($id);
        return response()->json($cities);
    }

    public function addCity(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'country_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }

       $id = $this->city->insertGetId($request);
       $cities = $this->city->fetchCities();

       return response()->json($cities);
    }

    public function updateCity(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'country_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }

        $this->city->UpdateRecord($request);
        $cities = $this->city->fetchCitiesByPage();
        return response()->json($cities);
    }

    public function deleteCity(Request $request, $id) {
         $this->city->DeleteCity($id);
         return response()->json('Successfully Deleted', 200);
     }

}
