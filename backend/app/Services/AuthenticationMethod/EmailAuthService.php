<?php
namespace App\Services\AuthenticationMethod;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Contracts\LoginInterface;
use Illuminate\Http\JsonResponse;

class EmailAuthService implements LoginInterface
{
    public function login($request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials))  {
                return response()->json([
                    'data' => [ 
                        'user' => $request->user()
                    ]
                ], 200); 
            }


            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
            
        } catch (\Throwable $th) {
            info('Email Auth Error: ' . $th->getMessage());
            return response()->json([
                'message' => 'Server Error'
            ], 500);
        }
    }
}