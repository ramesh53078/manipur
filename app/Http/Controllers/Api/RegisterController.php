<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class RegisterController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->only('user_type'), [
                'user_type' => 'required|in:visitor,employee',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['statusCode' => 400,'error' => $validator->errors()], 400);
            }
            
            $requestData['user_type'] = $request->input('user_type');

            if ($request->input('user_type') == 'employee') {
    
                $validator = Validator::make($request->only('name','designation','employee_code'), [
                    'name' => 'required',
                    'designation' => 'required',
                    'employee_code' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return response()->json(['statusCode' => 400,'error' => $validator->errors()], 400);
                }

                $user = User::where('employee_code', $request->input('employee_code'))->first();

                $requestData['name'] = $request->input('name');
                $requestData['designation'] = $request->input('designation');
                $requestData['employee_code'] = $request->input('employee_code');

            } elseif($request->input('user_type') == 'visitor') {
    
                $validator = Validator::make($request->only('name','email','phone_number'), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'phone_number' => 'required|digits:10',
                ]);
        
                if ($validator->fails()) {
                    return response()->json(['statusCode' => 400,'error' => $validator->errors()], 400);
                }
                
                $user = User::where('phone_number', $request->input('phone_number'))->first();

                $requestData['name'] = $request->input('name');
                $requestData['email'] = $request->input('email');
                $requestData['phone_number'] = $request->input('phone_number');
            }

            if ($user) {
                // If user exists, update the data
                $user->update([
                    'updated_at' => now(),
                ]);
            } else {
                // If user does not exist, create a new user
                $user = User::create($requestData);
            }

            try {
                $token = JWTAuth::fromUser($user);
            } catch (JWTException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to generate token.',
                ], 500);
            }

            return response()->json([
                'statusCode' => 200,
                'token' => $token,
                'data' => $user,
            ]);


        } catch (\Exception $th) {
            return response()->json(['statusCode' => 500,'error' => $th->getMessage()], 500);
        }
    }
}
