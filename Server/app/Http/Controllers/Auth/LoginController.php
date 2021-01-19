<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Permission;
use App\Models\Workforce;
use App\Models\WorkforceNature;
use DB;

class LoginController extends Controller
{
  public function __construct(Permission $permission,Workforce $Workforce)
  {
    $this->permission = $permission;
    $this->Workforce = $Workforce;
  }
    // public function login (Request $request) {
    //     return response ($request->all(), 422);
    // }

    // public function register (Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);
    //     if ($validator->fails())
    //     {
    //         return response(['errors'=>$validator->errors()->all()], 422);
    //     }
    //     $request['password']=Hash::make($request['password']);
    //     $request['remember_token'] = Str::random(10);
    //     $user = User::create($request->toArray());
    //     $token = $user->createToken('Laravel Password Grant Client')->accessToken;
    //     $response = ['token' => $token];
    //     return response($response, 200);
    // }

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
                if($user->role_id == 3){
                  $workForce = $this->Workforce->getrecordByUserId($user->id);
                }else{
                  $workForce='';
                }
                $record  = array();
                $profile =
                DB::table('users')
                  ->leftJoin('admin_profiles','users.id','admin_profiles.user_id')
                  ->leftJoin('roles','users.role_id','roles.id')
                  ->where('users.id',$user->id)
                  ->select('admin_profiles.*','roles.name as role_name')
                  ->first();
                // $record['profile'] = $profile;

                // $record['roles_associated'] = $roles_associated;
                $data = \Location::get($request->ip);
                if($data){
                  $detail = DB::table('countries')
                              ->leftJoin('languages','countries.language_id','=','languages.id')
                              ->leftJoin('currencies','countries.currency_id','currencies.id')
                              ->select('countries.*','languages.short_code as language_code','currencies.code as currency_code')
                              ->where('countries.code',$data->countryCode)
                              ->first();
                  // $data->addtional_info = $detail;
                }
                else {
                  $detail = DB::table('countries')->where('code','US')->first();
                }
                $allpermissions = DB::table('permissions')->get();
                foreach ($allpermissions as $key => $permission) {
                  $check = DB::table('role_permissions')->where('role_id',$user->role_id)->where('permission_id',$permission->id)->first();
                  if($check){
                    $permission->checked = true;
                  }
                  else{
                    $permission->checked = false;

                  }
                }
                $response = [
                    'token' => $token,
                    'email' => $request->email,
                    'user_id' => $user->id,
                    'profile' => $profile,
                    'ip_info' => $detail,
                    'permissions' => $allpermissions,
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

    public function fetchLanguags(Request $request) {
        $array = array('languages' => 'sss');
       return response()->json(['languages' =>  $array]);
    }


    public function logout (Request $request) {
        $token = DB::table('oauth_access_tokens')
                   ->where('user_id',$request->user_id)
                   ->delete();
        // $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }


}
