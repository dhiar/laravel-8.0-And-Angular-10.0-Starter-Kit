<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Country;
use DB;

class CountryController extends Controller
{
    public function __construct(Country $country)
    {
      $this->country = $country;
    }
    public function currencyDetail(Request $request){
     $details = DB::table('countries_details')->get();
     foreach ($details as $key => $value) {
       $value->new_name = $value->currency_code . ' For ' . $value->name;
       $value->new_name_for_country_code = $value->code . ' For ' . $value->name;
     }
      return response()->json($details);
    }
    public function fetchCountries(Request $request) {
        if($request->searchText){
            $countries = $this->country->fetchCountriesForSearch($request->searchColumn,$request->searchText);
            return response()->json($countries);
        }
        if($request->page && !$request->data_sort_order){
            $countries = $this->country->fetchCountriesByPage();
            return response()->json($countries);
        }
        else if($request->data_sort_order){
            $countries = $this->country->fetchCountriesBySorting($request->sorted_colum,$request->data_sort_order);
            return response()->json($countries);
        }
        $countries = $this->country->fetchCountries();
        return response()->json($countries);

    }

    public function activefetchCountries(){
      $countries = $this->country->actvfetchCountries();
      return response()->json($countries);
    }
    public function getCountryById(Request $request, $id) {
       $country =  $this->country->getCountryById($id);
       return response()->json(['countries' => $country]);
    }

    public function addCountry(Request $request) {
      // dd($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'wrench_time' => 'required',
            'is_active' => 'required',
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }

        if($request->hasFile('country_flag')){
            $validator = Validator::make($request->all(), [
                'country_flag' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            if ($validator->fails())
            {
                $errors_array = array();
                foreach($validator->errors()->getMessages() as $key => $message){
                    $errors_array[$key] = $message[0];
                }
                return response($errors_array, 422);

            }
            $image = $request->file('country_flag');
            $filename    = time().'_country_flag.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('images/country_flag/');
            $image->move($destinationPath, $filename);
            $file_url = '/images/country_flag/'. $filename;

        }
        else{
            $file_url = $request->country_flag;
        }

       $id = $this->country->insertGetId($request,$file_url);
       $countries = $this->country->fetchCountries();

       return response()->json($countries);
    }

    public function updateCountry(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'wrench_time' => 'required',
            'is_active' => 'required',
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }
        if($request->hasFile('country_flag')){
            $validator = Validator::make($request->all(), [
                'country_flag' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            if ($validator->fails())
            {
                $errors_array = array();
                foreach($validator->errors()->getMessages() as $key => $message){
                    $errors_array[$key] = $message[0];
                }
                return response($errors_array, 422);

            }
            $image = $request->file('country_flag');
            $filename    = time().'_country_flag.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('images/country_flag/');
            $image->move($destinationPath, $filename);
            $file_url = '/images/country_flag/'. $filename;

        }
        else{
            $file_url = $request->country_flag;
        }

        $this->country->UpdateRecord($request, $file_url);
        $countries = $this->country->fetchCountriesByPage();
        return response()->json($countries);
    }

    public function deleteCountry(Request $request, $id) {
         $this->country->DeleteCountry($id);
         return response()->json('Successfully Deleted', 200);
     }
     public function checkInCordinate(Request $request) {

     $vertices_x = array(31.43164, 31.42879, 31.42981, 31.42686, 31.42535, 31.42597, 31.42062, 31.41806, 31.4156, 31.4107, 31.41223, 31.4126, 31.42212, 31.43128);    // x-coordinates of the vertices of the polygon
     $vertices_y = array(73.09746, 73.09214, 73.08476, 73.08947, 73.08522, 73.06853, 73.06622, 73.07029, 73.07025, 73.07291, 73.07214, 73.09403, 73.11978, 73.10622); // y-coordinates of the vertices of the polygon
     $points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
   //  $longitude_x = $_GET["longitude"];  // x-coordinate of the point to test
   //  $latitude_y = $_GET["latitude"];    // y-coordinate of the point to test

     $longitude_x = 31.422202;  // x-coordinate of the point to test
     $latitude_y = 73.089895;    // y-coordinate of the point to test
     if ($this->is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)){
       echo "Is in polygon!";
     }
     else echo "Is not in polygon";
    }

     private function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
     {
       $i = $j = $c = 0;
       for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) {
         if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
          ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
            $c = !$c;
       }
       return $c;
     }

}
