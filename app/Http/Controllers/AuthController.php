<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'page' => 'Login'
        ];
        return view('sign_in', $data);
    }
    public function authorization(Request $request)
    {
        try {
            $validate = $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ], [
                'email.required' => 'Anda belum memasukan email',
                'password.required' => 'Anda belum memasukan password'
            ]);
            $auth = Auth::attempt($validate);
            if (!$auth) throw new \ErrorException('Tidak dapat memverifikasi data anda');
            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil'
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
