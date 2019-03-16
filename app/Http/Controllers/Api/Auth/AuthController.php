<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    //login
    protected function check(Request $request)
    {
        try {
          $password = Hash::make($request->password);
          $data = User::select('email', 'password')->where('email', $request->email, 'password',  $password);
          $token = User::where('email', $request->email)->first();
            if (count($data)) {
              $temp = str_random(40);
              $token->update(['token', $temp]);
              return Response()->json(['status' => 200, 'description' => 'login berhasil !', $token->id => $token,]);
            }
        } catch (\Exception $e) {
          return response()
            ->json(['status' => false, 'description' => $e->getMessage()]);
        }

    }

    //register
    protected function create(Request $request)
    {
        try {
          $validator = Validator::make($request->all(), [
              'name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users',
              'telephone' => 'required|string|max:16',
              'password' => 'required|string|min:6|confirmed',
          ]);

          if($validator->passes()){
            User::create([
              'name' => $request->name,
              'email' => $request->email,
              'telephone' => $request->telephone,
              'password' => Hash::make($request->password),
            ]);
            return Response()->json(['status' => 200, 'description' => 'register berhasil']);
          }
        } catch (\Exception $e) {
          return response()
            ->json(['status' => false, 'description' => $e->getMessage()]);
        }

    }
}
