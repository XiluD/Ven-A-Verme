<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class AdminsController extends Controller
{
    protected function show($email, $password){
        $admin = Admin::where('email', $email)->first();
        if($admin && Hash::check($password, $admin->password)){
            return response()->json(['operation' => 'Success',
                                     'api_token' => $admin->api_token], JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['operation' => 'Fail'], JsonResponse::HTTP_OK);
        }
    }
    
    protected function create(Request $request){
        $email = $request->get('email');
        $password = $request->get('password');
        
        $admin = Admin::where('email', $email)->first();
        if($admin){
            return response()->json(['operation' => 'Fail'], JsonResponse::HTTP_OK);
        }
        else{
            $admin = Admin::create([
                'email' => $email,
                'password' => Hash::make($password),
                'api_token' => Str::random(80),
            ]);
    
            return response()->json(['operation' => 'Success',
                                     'api_token' => $admin->api_token], JsonResponse::HTTP_CREATED);
        }
    }

    protected function firstAdmin(){
        return response()->json(Admin::first(), JsonResponse::HTTP_OK);

    }
    
}
