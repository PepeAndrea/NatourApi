<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use GuzzleHttp\Exception\ClientException;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

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
        $request->user()->currentAccessToken()->delete();

        return $this->success(null,'Logout effettuato');
    }

    public function getProviderUser(Request $request,$provider) {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        
        try {
            $user = Socialite::driver($provider)->userFromToken($request->provider_token);
        } catch (ClientException $exception) {
            return $this->error("Credenziali fornite non valide",422);
        }

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'status' => true,
            ]
        );
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );
        $token = $userCreated->createToken('natourapitoken')->plainTextToken;

        $response = [
            'user' => $userCreated,
            'token' => $token,
        ];

        return $this->success($response,'Utente autenticato');
    }

    protected function validateProvider($provider) {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            return $this->error("Login tramite provider consentito solo con Facebook e Google",422);
        }
    }
    
    
    public function redirectToProvider($provider) {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider) {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        
        try {
            $user = Socialite::driver($provider)->stateless()->user();

        } catch (ClientException $exception) {
            return $this->error("Credenziali fornite non valide",422);
        }

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'status' => true,
            ]
        );
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );
        $token = $userCreated->createToken('natourapitoken')->plainTextToken;

        $response = [
            'user' => $userCreated,
            'token' => $token,
            'testdata' =>$user
        ];

        return $this->success($response,'Utente autenticato');
    }
    
}
