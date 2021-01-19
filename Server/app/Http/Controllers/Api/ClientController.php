<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\WorkRoles;
use Illuminate\Http\Request;
use Validator;
use App\Models\Client;

class ClientController extends Controller
{

  public function __construct(Client $Client)
  {
    $this->Client = $Client;
  }
    public function getAllClient(Request $request){
      if($request->searchText){
          $Client = $this->Client->fetchClientForSearch($request->searchColum,$request->searchText);
          return response()->json($Client);
      }
      if($request->page && !$request->data_sort_order){
          $Client = $this->Client->fetchClientByPage();
          return response()->json($Client);
      }
      else if($request->data_sort_order){
          $Client = $this->Client->fetchClientBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($Client);
      }
      $Client = $this->Client->fetchClient();
      return response()->json($Client);

    }

    public function ActivegetAllClient(){
      $Client = $this->Client->ActivefetchClient();
      return response()->json($Client);
    }
    public function clientStore(Request $request){

        $rules = [
            // 'user_id' => 'required',
            'client_name' => 'required',
            'contact_person_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->messages()
            ];
            return response()->json($response);
        }
         $data = $request->all();

        if($client = Client::create($data)){
            $response = [
                'data' => $client,
                'status' => true,
                'success' => 1,
                'message' => 'Client added successfully'
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
            return response()->json($response);
        }

    }

    public function clientUpdate(Request $request){
        $rules = [
            // 'user_id' => 'required',
            'id' => 'required|integer',
            'client_name' => 'required',
            'contact_person_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->messages()
            ];
            return response()->json($response);
        }
        $data = $request->all();

        $client = Client::find($request->id);
        if($client->update($data)){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Client updated successfully'
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
            return response()->json($response);
        }

    }

    public function getClientById($id=0){
      $Client = $this->Client->getrecord($id);
      if($Client){
        $show_client=[
                  'data' => $Client,
                  'message' => 'Client Detail',
                  'success' => '1',
                  'status' => 'true'
                ];
      }else{
        $show_client=[
            'message' => 'Something probelm in internal system',
            'success' => '0',
            'status' => 'false'
          ];
      }
        return response()->json($show_client);

    }

    public function deleteClient($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json();
        }

        $client = Client::find($id);
        if($client->delete()){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Client deleted successfully'
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
            return response()->json($response);
        }
    }

    public function searchClient(Request $request){
        $rules = [
            'search' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->messages()
            ];
            return response()->json($response);
        }

        $client = Client::where(function ($q) use($request) {
            $q->orWhere('client_name','LIKE',"%$request->search%");
            $q->orWhere('contact_person_name','LIKE',"%$request->search%");
            $q->orWhere('company_name','LIKE',"%$request->search%");
            $q->orWhere('email','=',$request->search);
        })->get();

        if(count($client) > 0){
            $response = [
                'data' => $client,
                'status' => true,
                'success' => 1
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Record Not Found'
            ];
            return response()->json($response);
        }
    }
}
