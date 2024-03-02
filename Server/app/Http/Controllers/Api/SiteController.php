<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Site;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    protected $Site;
    public function __construct(Site $Site)
    {
        $this->Site = $Site;
    }
    public function getAllSite(Request $request){
      if($request->searchText){
          $Site = $this->Site->fetchSiteForSearch($request->searchColum,$request->searchText);
          return response()->json($Site);
      }
      if($request->page && !$request->data_sort_order){
          $Site = $this->Site->fetchSiteByPage();
          return response()->json($Site);
      }
      else if($request->data_sort_order){
          $Site = $this->Site->fetchSiteBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($Site);
      }
      $Site = $this->Site->fetchSite();
      return response()->json($Site);
    }

    public function ActivegetAllSite(){
      $Site = $this->Site->actvfetchSite();
      return response()->json($Site);
    }

    public function updateSitesByMap(Request $request){
      foreach ($request->all() as $key => $value) {
        DB::table('sites')
          ->where('id',$value['id'])
          ->update([
            'latitude' => $value['latitude'],
            'longitude' => $value['longitude']
          ]);
      }
      return response()->json("success");
    }


    public function siteStore(Request $request){
        $rules = [
            'zone_id' => 'required',
            // 'client_id' => 'required',
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }
        $data = $request->all();
        $zoneId=$request->zone_id;
        $getrecord=Zone::where('id',$zoneId)->first();
        if(!$getrecord){
          $response = [
              'status' => false,
              'success' => 0,
              'message' => 'Something probelm in internal system'
          ];
          return response()->json($response);
        }
        $coords = json_decode($getrecord->coordinates);
        if($coords){
          $data['latitude']=$coords[0]->lat;
          $data['longitude']=$coords[0]->lng;
        }

        // dd($coords[0]->lat);
        // $lanti=$getrecord->coordinates;

        if($site = Site::create($data)){
            $response = [
                'data' => $site,
                'status' => true,
                'success' => 1,
                'message' => 'Site added successfully'
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

    public function siteUpdate(Request $request){

        $rules = [
            'id'=> 'required',
            'zone_id' => 'required',
            // 'client_id' => 'required',
            'name' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }
        $data = $request->all();

        $site = Site::find($request->id);
        if($site->update($data)){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Site updated successfully'
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

    public function getSiteById($id=0){
      if($id){
          $sites = $this->Site->getrecord($id);
          if($sites){
            $show_site=[
                'data' => $sites,
                'message' => 'Sites Detail',
                'success' => '1',
                'status' => 'true'
              ];
          }
      }else{
        $show_site=[
          'message' => 'Something probelm in internal system',
          'success' => '0',
          'status' => 'false'
        ];
      }
      return response()->json($show_site);
        // if($id == 0){
        //     $response = [
        //         'status' => false,
        //         'success' => 0,
        //         'message' => 'ID required'
        //     ];
        //     return response()->json($response);
        // }
        //
        // $site = Site::find($id);
        // if(!is_null($site)){
        //     $response = [
        //         'data' => $site,
        //         'status' => true,
        //         'success' => 1
        //     ];
        //     return response()->json($response);
        // }else{
        //     $response = [
        //         'status' => false,
        //         'success' => 0,
        //         'message' => 'Record not found'
        //     ];
        //     return response()->json($response);
        // }
    }

    public function deleteSite($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }

        $site = Site::find($id);
        if($site->delete()){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Site deleted successfully'
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

    /*public function searchSite(Request $request){
        $rules = [
            'search' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
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
    }*/
}
