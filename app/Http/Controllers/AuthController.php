<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(RegisterRequest $request) {
        $fields = $request->validated();
        
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('natourapitoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->success($response,'Utente autenticato');
    }

    public function login(LoginRequest $request) {
        $fields = $request->validated();

        // Verifica email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return $this->error('Credenziali non valide', 401);
        }

        $token = $user->createToken('natourapitoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->success($response,'Utente autenticato');
    }

    public function logout(Request $request) {
        //auth()->user()->tokens()->delete();

        return $this->success(null,'Logout effettuato');
    }



}
