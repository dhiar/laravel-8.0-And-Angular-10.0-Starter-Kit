<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\State;
use App\Models\Country;
use DB;

class StateController extends Controller
{
    public function __construct(State $state, Country $country)
    {
      $this->state = $state;
      $this->country = $country;
    }

    public function fetchStates(Request $request) {
        if($request->searchText){
            $states = $this->state->fetchStatesForSearch($request->searchColumn,$request->searchText);
            return response()->json($states);
        }
        if($request->page && !$request->data_sort_order){
            $states = $this->state->fetchStatesByPage();
            return response()->json($states);
        }
        else if($request->data_sort_order){
            $states = $this->state->fetchStatesBySorting($request->sorted_colum,$request->data_sort_order);
            return response()->json($states);
        }
        $states = $this->state->fetchStates();
        return response()->json($states);

    }

    public function activefetchStates(){
      $states = $this->state->actvfetchStates();
      return response()->json($states);
    }

    public function getStateById(Request $request, $id) {
       $state =  $this->state->getStateById($id);
       return response()->json($state);
    }

    public function getStatesByCountry(Request $request, $id) {
        $states =  $this->state->getStatesByCountry($id);
        return response()->json($states);
     }

    public function addState(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }

       $id = $this->state->insertGetId($request);
       $states = $this->state->fetchStates();

       return response()->json($states);
    }

    public function updateState(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }

        $this->state->UpdateRecord($request);
        $states = $this->state->fetchStatesByPage();
        return response()->json($states);
    }

    public function deleteState(Request $request, $id) {
         $this->state->DeleteState($id);
         return response()->json('Successfully Deleted', 200);
     }

}
