<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsController extends Controller
{
    protected function create(/*array $data*/)
{
    $data = ['email'=> 'pilombo@gmail.com', 'password'=> '123abc'];
    return Admin::forceCreate([
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'api_token' => Str::random(80),
    ]);
}
}
