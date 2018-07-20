<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Config;
use App\Student;


class SignInController extends Controller
{


    public function studentSignin(Request $request){


      $validator = \Validator::make($request->all(),[

        'email' => 'required|string|max:35|email',
        'password' => 'required|string|max:35'

      ]);

      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }


  $credentials = $request->only('email', 'password');

      try {
              // attempt to verify the credentials and create a token for the user





              if (! $token = JWTAuth::attempt($credentials)) {
                  return response()->json(['error' => 'invalid_credentials'], 401);

              }
          } catch (JWTException $e) {
              // something went wrong whilst attempting to encode the token
              return response()->json(['error' => 'could_not_create_token'], 500);
          }

          // all good so return the token
          return response()->json(compact('token'));
      }


      public function megaSignIn(Request $request){

        $validator = \Validator::make($request->all(),[

          'idx' => 'required',
          'password' => 'required'


        ]);

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }


      $credentials = $request->only('idx', 'password');

        try {
                // attempt to verify the credentials and create a token for the user





                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);

                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            // all good so return the token
            return response()->json(compact('token'));

      }

}
