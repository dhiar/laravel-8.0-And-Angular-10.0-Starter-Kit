<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Language;
use App\Models\Country;
use DB;

class LanguageController extends Controller
{
    public function __construct(Language $language, Country $country)
    {
      $this->language = $language;
      $this->country = $country;
    }

    public function fetchLanguages(Request $request) {
        if($request->searchText){
            $languages = $this->language->fetchLanguagesForSearch($request->searchColum,$request->searchText);
            return response()->json($languages);
        }
        if($request->page && !$request->data_sort_order){
            $languages = $this->language->fetchLanguagesByPage();
            return response()->json($languages);
        }
        else if($request->data_sort_order){
            $languages = $this->language->fetchLanguagesBySorting($request->sorted_colum,$request->data_sort_order);
            return response()->json($languages);
        }
        $languages = $this->language->fetchLanguages();
        return response()->json($languages);

    }

    public function ActivefetchLanguages(){
      $languages = $this->language->actvfetchLanguages();
      return response()->json($languages);
    }

    public function getLanguageById(Request $request, $id) {
       $language =  $this->language->getLanguageById($id);
       return response()->json($language);
    }

     public function fetchLanguagesByCountry(Request $request, $id) {
        $languages =  $this->language->fetchLanguagesByCountry($id);
        return response()->json($languages);
    }

    public function addLanguage(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }
        if($request->hasFile('image')){
            $validator = Validator::make($request->all(), [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            if ($validator->fails())
            {
                $errors_array = array();
                foreach($validator->errors()->getMessages() as $key => $message){
                    $errors_array[$key] = $message[0];
                }
                return response($errors_array, 422);

            }
            $image = $request->file('image');
            $filename    = time().'_country.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/language_flag/');
            $image->move($destinationPath, $filename);
            $file_url = '/images/language_flag'.'/'. $filename;

        }
        else{
            $file_url = '';
        }

       $id = $this->language->insertGetId($request,$file_url);
       $languages = $this->language->fetchLanguages();

       return response()->json($languages);
    }

    public function updateLanguage(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }
        if($request->hasFile('image')){
            $validator = Validator::make($request->all(), [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            if ($validator->fails())
            {
                $errors_array = array();
                foreach($validator->errors()->getMessages() as $key => $message){
                    $errors_array[$key] = $message[0];
                }
                return response($errors_array, 422);

            }
            $image = $request->file('image');
            $filename    = time().'_country.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/language_flag/');
            $image->move($destinationPath, $filename);
            $file_url = '/images/language_flag'.'/'. $filename;

        }
        else{
            $file_url = $request->image;
        }

        $this->language->UpdateRecord($request,$file_url);
        $languages = $this->language->fetchLanguagesByPage();
        return response()->json($languages);
    }

    public function deleteLanguage(Request $request, $id) {
         $this->language->DeleteLanguage($id);
         return response()->json('Successfully Deleted', 200);
     }

}
