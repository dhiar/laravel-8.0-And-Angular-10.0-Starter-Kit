<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\WorkRoles;
use App\Models\Workforce;
use App\Models\WorkforceNature;
use App\Models\Permission;
use DB;

class WorkForceLoginController extends Controller
{

  public function __construct(Workforce $Workforce)
  {
    $this->Workforce = $Workforce;
  }

  public function login (Request $request) {
      $validator = Validator::make($request->all(), [
          'email' => 'required|string|email|max:255',
          'password' => 'required',
      ]);
      if ($validator->fails())
      {
          $errors_array = array();
          foreach($validator->errors()->getMessages() as $key => $message){
              $errors_array[$key] = $message[0];
          }
          return response($errors_array, 422);

      }
      $user = User::where('email', $request->email)->first();
      if ($user) {
          if (Hash::check($request->password, $user->password)) {
              $token = $user->createToken('Laravel Password Grant Client')->accessToken;
              $record  = array();
              $profile =
              DB::table('users')
                ->leftJoin('admin_profiles','users.id','admin_profiles.user_id')
                ->leftJoin('roles','users.role_id','roles.id')
                ->where('users.id',$user->id)
                ->select('admin_profiles.*','roles.name as role_name')
                ->first();
              $data = \Location::get($request->ip);
              if($data){
                $detail = DB::table('countries')
                            ->leftJoin('languages','countries.language_id','=','languages.id')
                            ->leftJoin('currencies','countries.currency_id','currencies.id')
                            ->select('countries.*','languages.short_code as language_code','currencies.code as currency_code')
                            ->where('countries.code',$data->countryCode)
                            ->first();

              }
              else {
                $detail = DB::table('countries')->where('code','US')->first();
              }

              $workForce = $this->Workforce->getrecordByUserId($user->id);
              $response = [
                  'token' => $token,
                  'email' => $request->email,
                  'user_id' => $user->id,
                  'profile' => $profile,
                  'ip_info' => $detail,
                  'detailWorkForce' => $workForce
              ];
              return response()->json($response);

              return response($response, 200);
          } else {
              $response = ["password" => "Password mismatch"];
              return response($response, 422);
          }
      } else {
          $response = ["email" =>'User does not exist'];
          return response($response, 422);
      }
  }




}
