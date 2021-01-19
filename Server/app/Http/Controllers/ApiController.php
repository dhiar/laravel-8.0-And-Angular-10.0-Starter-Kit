<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User_role;
use App\Models\User;
class ApiController extends Controller
{

  public function get_country(Request $request){

  }

  public function login_user(Request $request){
  $email=$request->email;
  $password=$request->password;
  $auth=[
      'email'=> $email,
      'password'=> $password
    ];
    if(Auth::attempt($auth)){
      $user = Auth::user()->RoleUser;
      $user_role_id=$user->role_id;
      $user_role=Role::with('permission')->find($user_role_id);
      // $getPermission=P::with('role_user')->where('role_id',$user_role_id)->get();
      $login_user=[
        'Role' => $user_role,
        'message' =>'You Are Successfully Login',
        'status' => 'true'
      ];
    }else{
      $login_user=[
        'message' => 'Your Crediental is wrong',
        'status' => 'false'
      ];
    }
    return response()->json($login_user);
}



   public function add_role(Request $request){
     $data=$request->all();
     // $data['title']=$request->title;
     if($role = Role::create($data)){
       Permission::create([
              'role_id' => $role->id,
              'edit_role' => $request->edit_role,
              'delete_role' => $request->delete_role,
              'show_role' => $request->show_role,
              'create_role' => $request->create_role,
              'add_user' => $request->add_user,
              'delete_user' => $request->delete_user,
              'edit_user' => $request->edit_user,
              'show_user' => $request->show_user,
          ]);
          $add_role_user=[
            'create_role' => 'add Role User successfully',
            'status' => 'true'
          ];
     }else{
       $add_role_user=[
         'create_role' => 'Some Thing Went Wrong',
         'status' => 'false'
       ];
     }
       return response()->json($add_role_user);
   }

   public function edit_role(Request $request){
     $data = $request->all();
     $user  = Role::find($request->id);
     if($user->update($data)){
         $edit_role_user=[
           'edit_role' => 'Edit Role User successfully',
           'status' => 'true'
         ];
     }else{
       $edit_role_user=[
         'edit_role' => 'Some Thing Went Wrong',
         'status' => 'false'
       ];
     }
        return response()->json($edit_role_user);
   }

   public function show_role(Request $request){
     $user_role_id=$request->id;
     $SelectShowRole=Role::where('id',$user_role_id)->first();
     if($SelectShowRole){
       $show_role_user=[
         'show_role_data' => $SelectShowRole,
         'show_role' => 'Show Role User successfully',
         'status' => 'true'
       ];
     }else{
       $show_role_user=[
         'show_role' => 'Some Thing Went Wrong',
         'status' => 'false'
       ];
     }
     return response()->json($show_role_user);
   }

   public function delete_role(Request $request){
     $user_role_id=$request->id;
     $SelectDelRole=Role::where('id',$user_role_id)->delete();
     if($SelectDelRole){
       $del_role_user=[
         'del_role' => 'Delete Role User successfully',
         'status' => 'true'
       ];
     }else{
       $del_role_user=[
         'del_role' => 'Some Thing Went Wrong',
         'status' => 'false'
       ];
     }
     return response()->json($del_role_user);
   }


   public function add_user(Request $request){
     $mail=$request->email;
     $selectuser=User::where('email',$mail)->first();
     if($selectuser){
       $add_user=[
         'create Users' => 'Your Email Already Exist',
         'status' => 'false'
       ];
     }else{
         $addv=new User();
         $addv->name=$request->name;
         $addv->email=$request->email;
         $addv->password=Hash::make($request->password);
         $addv->save();
         $uid=$addv->id;
         $adduser_role=new User_role();
          $adduser_role->user_id=$uid;
          $adduser_role->role_id=$request->role_id;
          $adduser_role->save();
         if($adduser_role->save()){
           $add_user=[
             'create_Users' => 'add user successfully',
             'status' => 'true'
           ];
         }else{
         $add_user=[
           'create_Users' => 'Some Thing Went Wrong',
           'status' => 'false'
           ];
         }
       }
         return response()->json($add_user);
      }

      public function edit_user(Request $request){
        $data = $request->all();
        $user  = User::find($request->id);
        if($user->update($data)){
          $edit_user=[
            'edit_Users' => 'User Has Been Successfully Updated',
            'status' => 'true'
          ];
        }else{
          $edit_user=[
            'edit_Users' => 'SomeThing Went Wrong',
            'status' => 'false'
          ];
        }
           return response()->json($edit_user);
        }

         public function show_user(Request $request){
               $uid=$request->id;
               $getuser=User::where('id',$uid)->first();
               if($getuser){
                 $show_user=[
                   'show_Users' => $getuser,
                   'status' => 'true'
                 ];
               }else{
                 $show_user=[
                   'show_Users' => 'Some Thing Went Wrong',
                   'status' => 'false'
                 ];
               }
               return response()->json($show_user);
            }

            public function delete_user(Request $request){
              $uid=$request->id;
              $getuser=User::where('id',$uid)->delete();
              if($getuser){
                $del_user=[
                  'del_Users' => 'User Has Been Delete Successfully',
                  'status' => 'true'
                ];
              }else{
                $del_user=[
                  'del_Users' => 'Some Thing Went Wrong',
                  'status' => 'false'
                ];
              }
              return response()->json($del_user);
            }


   public function get_role(Request $request){
       $data = Role::all();
       if($data){
         $get_roles=[
           'all_roles' => $data,
           'Success' => '1',
           'status' => 'true',
           'Message' => 'Successfully Get Role'
         ];
       }else{
         $get_roles=[
           'all_roles' => 'SomeThing Went Wrong',
            'Success' => '0',
           'status' => 'false'
         ];
       }
       return response()->json($get_roles);
  }
}
