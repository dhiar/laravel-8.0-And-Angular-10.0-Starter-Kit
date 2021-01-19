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

class UploadController extends Controller
{

    public function uploadFile(Request $request) {

        if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,docx,doc,csv',
            ]);
            if ($validator->fails())
            {
                $errors_array = array();
                foreach($validator->errors()->getMessages() as $key => $message){
                    $errors_array[$key] = $message[0];
                }
                return response($errors_array, 422);

            }
            $image = $request->file('file');
            $filename    = time().'_general.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/general/');
            $image->move($destinationPath, $filename);
            $file_url = '/images/general'.'/'. $filename;

        }
        else{
            $file_url = '';
        }

       return response()->json($file_url);
    }

}
