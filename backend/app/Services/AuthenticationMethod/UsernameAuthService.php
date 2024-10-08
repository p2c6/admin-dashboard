<?php
namespace App\Services\AuthenticationMethod;

use Illuminate\Support\Facades\Auth;
use App\Services\Contracts\LoginInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UsernameAuthService implements LoginInterface
{
    public function login($request) : JsonResponse 
    {
        try {
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username or Email is required.'
            ]);

            if (Auth::attempt($credentials, $request->input('remember'))) {
                return response()->json([
                    'data' => [ 
                        'user' => $request->user()
                    ]
                ], 200); 
            }

            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
            
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);

        } catch (\Throwable $th) {
            info('Username Auth Error: ' . $th->getMessage());
            return response()->json([
                'message' => 'Server Error'
            ], 500);
        }
    }
}