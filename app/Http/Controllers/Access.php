<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Access extends Controller
{
    private $request;
    
    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", 
            'sub' => $user->id, 
            'iat' => time(),
            'exp' => time() + 60*60
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    } 
   
    public function authenticate(User $user) {

        $validator = Validator::make($this->request->all(), [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

         if ($validator->fails()) {
            return response()->json([
            'error' => 'The Given Input is not Correct.'
            ], 400);
         }

        $user = User::where('email', $this->request['email'])->first();
        $data = [];

        if (!$user) {
            $user = User::create([
                'name' => $this->request['name'],
                'email' => $this->request['email'],
                'password' => Hash::make($this->request['password']),
                'is_active' => 1,
            ]);
        }
        
        if (Hash::check($this->request['password'], $user->password)) {
            $data["user"] = $user;
            $data["token"] = $this->jwt($user);
            return response()->json([
                'data' => $data,
            ], 200);
        }
        
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }
}
