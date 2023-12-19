<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\Admin\Feedback;
class FeedbackController extends Controller
{
    public function feedbackAction(Request $request)
    {
        $user = JWTAuth::authenticate($request->token);

        $validatedData = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 400);
        }

        $feedback = Feedback::create([
            'user_id' => $user->id,
            'description' => $request->input('description'),
        ]);
        return response()->json(['statusCode' => 201 ,'message' => 'Feedback submitted successfully']);
    }
}
