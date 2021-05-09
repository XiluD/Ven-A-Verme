<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Admin;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'api_token' => 'required'
        ]);
        if(in_array($request->query('api_token'), Admin::all('api_token')->pluck('api_token')->toArray())){
            return $next($request);
        }
        else{
            return response()->json(['error' => 'API Token not valid', 'Supplied Token ' => $request->query('api_token')], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }
}
