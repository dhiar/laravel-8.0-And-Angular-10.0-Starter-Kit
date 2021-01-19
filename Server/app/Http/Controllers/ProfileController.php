<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use DB;

class ProfileController extends Controller
{

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
                $response = ['token' => $token,'email' => $request->email];
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

    public function updateProfile(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'about_me' => 'required',
            'profile_pic' => 'required'
        ]);
        if ($validator->fails())
        {
            $errors_array = array();
            foreach($validator->errors()->getMessages() as $key => $message){
                $errors_array[$key] = $message[0];
            }
            return response($errors_array, 422);

        }
        if($request->hasFile('profile_pic')){
            $validator = Validator::make($request->all(), [
                'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            if ($validator->fails())
            {
                $errors_array = array();
                foreach($validator->errors()->getMessages() as $key => $message){
                    $errors_array[$key] = $message[0];
                }
                return response($errors_array, 422);

            }
            $image = $request->file('profile_pic');
            $filename    = time().'_profile.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('images/profile_pic/');
            $image->move($destinationPath, $filename);
            $file_url = '/images/profile_pic/'. $filename;

        }
        else{
            $file_url = $request->profile_pic;
        }
        if($request->password){
          DB::table('users')
            ->where('id',$request->user_id)
            ->update(['password' => Hash::make($request->password)]);
        }
        if($request->email){
          DB::table('users')
            ->where('id',$request->user_id)
            ->update(['email' => $request->email]);
        }
        $paramsArray =  [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'about_me' => $request->about_me,
            'profile_pic' => $file_url
          ];
        DB::table('admin_profiles')->where('user_id',$request->user_id)->update($paramsArray);
         return response()->json(['success' =>  'Updated Successfully!']);
    }

    public function fetchProfile(Request $request, $id) {
      $user_profile =  DB::table('admin_profile')->where('user_id',$id)->first();
      return response()->json(['profile' =>  $user_profile]);
    }



}
