<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

class AuthController extends BaseController
{
    public function login(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('apiToken')->plainTextToken;
            $success['name'] = $authUser->name;


            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Unauthorised', ['error'=>'Unauthorised']);
        }
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('apiToken')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User created successfully.');
    }

    public function logout(Request $request) {
            if (Auth::check()) {
                
            Auth::user()->tokens()->delete();

            
            }
            
        return $this->sendResponse(null, 'User logged out successfully.');
    }
}
