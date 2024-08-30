<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ],);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon cek data anda!',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['role'] = $user->role;
            $success['token'] = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'data' => $success
            ]);
        } catch (UniqueConstraintViolationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terpakai!',
                'data' => null
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], [
            'email.required' => 'Harap masukkan alamat email',
            'email.email' => 'Alamat email tidak valid',
            'email.exists' => 'Alamat email tidak terdaftar',
            'password.required' => 'Harap masukan kata sandi anda',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode(' dan ', $validator->errors()->all()),
                'data' => []
            ], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                // 'data' => $auth,
                'data' => $success
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi anda salah!',
                'data' => []
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil'
            ]);
        }
    }
}
