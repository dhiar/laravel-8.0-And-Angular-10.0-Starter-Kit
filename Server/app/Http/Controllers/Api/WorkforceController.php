<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\WorkRoles;
use Illuminate\Http\Request;
use App\Models\Workforce;
use App\Models\WorkforceNature;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;
use DB;
class WorkforceController extends Controller
{
  public function __construct(Workforce $Workforce)
  {
    $this->Workforce = $Workforce;
  }
    public function getAllWorkForce(Request $request){
      if($request->searchText){
          $Workforce = $this->Workforce->fetchWorkForceForSearch($request->searchColum,$request->searchText);
          return response()->json($Workforce);
      }
      if($request->page && !$request->data_sort_order){
          $Workforce = $this->Workforce->fetchWorkForceByPage();
          return response()->json($Workforce);
      }
      else if($request->data_sort_order){
          $Workforce = $this->Workforce->fetchWorkForceBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($Workforce);
      }
      $Workforce = $this->Workforce->fetchWorkForce();
      return response()->json($Workforce);
    }

    public function ActivegetAllWorkForce(){
      $Workforce = $this->Workforce->ActivefetchWorkForce();
      return response()->json($Workforce);
    }

    public function workForceStore(Request $request){
        $rules = [
            'employee_name'=>'required|string',
            'job_nature_id'=>'required|integer',
            'category_id'=>'required|integer',
            'zone_id'=>'required|integer',
            'country'=>'required|integer',
            'country_code'=>'required|string',
            'phone'=>'required',
            'email'=>'required|string|email',
            'agency'=>'required|integer',
        ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }
        // if($request->createWorkForceUser == 1){
          $checkForEmail=$request->IsSendEmail;
          $workForcePass=Hash::make($request->password);
          $workForceEmail=$request->email;
          $workForceUsername=$request->workforce_user_name;
          $selectuser=User::where('email',$workForceEmail)->first();
          if($selectuser){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Work Force User Email Already Exist'
            ];
            return response()->json($response);
          }else{
            $addworkforceUser= new User();
            $addworkforceUser->first_name=$workForceUsername;
            $addworkforceUser->last_name=$workForceUsername;
            $addworkforceUser->password=$workForcePass;
            $addworkforceUser->email=$workForceEmail;
            $addworkforceUser->name=$workForceUsername;
            $addworkforceUser->role_id=3;
            $addworkforceUser->phone=$request->phone;
            $addworkforceUser->save();
            $lastid=$addworkforceUser->id;
            DB::table('admin_profiles')
              ->insert([
                'first_name' => $workForceUsername,
                'last_name' => 'Work Force',
                'user_id' => $lastid,
                'address' => 'Lorum Epsum',
                'about_me' => 'Lorum Epsum',
                'postal_code' => 123456
              ]);
          }
          if($checkForEmail == true){
            $to_name="Wise Store Apps";
            $to_email=$workForceEmail;
            // $from_email='us@example.com';
              $code="Work Force User Account";
              $data=array('name'=> $code, 'body' => 'Work Force User Account Create Successfully');
              \Mail::send('emails',$data,function($message) use ($to_name,$to_email){
                $message->from('crmuk85@gmail.com', 'Wise Store Apps');
                $message->to($to_email)
                ->subject('Mail from Wise Store Apps');
              });
        }
// }
        $data = $request->all();
        // $data['is_active'] = 1;
        if(isset($lastid)){
          $data['user_id'] = $lastid;
        }

        if($workForce = Workforce::create($data)){
            $response = [
                'data' => $workForce,
                'status' => true,
                'success' => 1,
                'message' => 'Work force added successfully'
            ];
        }else{
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'Something probelm in internal system'
            ];
        }
      // }
       return response()->json($response);
    }

    public function getWorkForceById($id=0){

      $workForce = $this->Workforce->getrecord($id);
      if($workForce){
        $show_workForce=[
                  'data' => $workForce,
                  'message' => 'Work Force Detail',
                  'success' => '1',
                  'status' => 'true'
                ];
      }else{
        $show_workForce=[
            'message' => 'Something probelm in internal system',
            'success' => '0',
            'status' => 'false'
          ];
      }

        return response()->json($show_workForce);

    }

    public function workForceUpdate(Request $request){
      $rules = [
          'employee_name'=>'required|string',
          'job_nature_id'=>'required|integer',
          'category_id'=>'required|integer',
          'zone_id'=>'required|integer',
          'country'=>'required|integer',
          'country_code'=>'required|string',
          'phone'=>'required',
          'email'=>'required|string|email',
          'agency'=>'required|integer',
      ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }
        if(isset($request->password)){
          $workForcePassUpdate=Hash::make($request->password);
        }
        else{
          $p=User::where('id',$request->user_id)->select('password')->first();
          $pass=$p->password;
          $workForcePassUpdate=$pass;
        }
        $checkUpadated=$request->IsLogingInfoUpdate;
        $data = $request->all();
        if($checkUpadated == true){
          DB::table('users')
              ->where('id',$request->user_id)
              ->update(['first_name' => $request->workforce_user_name,
                'last_name' => $request->workforce_user_name,
                'name' => $request->workforce_user_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $workForcePassUpdate
                ]);
        }
        $workRole = Workforce::find($request->id);
        if($workRole->update($data)){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Work force updated successfully'
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

    public function deleteWorkForce($id=0){
        if($id == 0){
            $response = [
                'status' => false,
                'success' => 0,
                'message' => 'ID required'
            ];
            return response()->json($response);
        }

        $workForce = Workforce::find($id);

        if($workForce->delete()){
            $response = [
                'status' => true,
                'success' => 1,
                'message' => 'Work force deleted successfully'
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
      public function FetchWorkNature(){
        $get=WorkforceNature::all();
        if($get){
          $AllWOrkNature = [
              'data' => $get,
              'status' => true,
              'success' => 1,
              'message' => 'Work Nature'
          ];
        }else{
          $AllWOrkNature = [
              'status' => false,
              'success' => 0,
              'message' => 'Something probelm in internal system'
          ];
        }
        return response()->json($AllWOrkNature);
      }
}
