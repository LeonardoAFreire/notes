<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // Form Validation

        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:18'
            ],
            // Messages errors
            [
                'text_username.required' => 'Username is required.',
                'text_username.email' => 'Username must be a valid email address.',
                'text_password.required' => 'Password is required.',
                'text_password.min' => 'Password must have more than :min characters.',
                'text_password.max' => 'Password must have no more than :max characters.',
            ]
        );

        //    test db connection

        try {

            DB::connection()->getPdo();
            echo 'connection is ok';
        } catch (\PDOException $e) {
            echo 'Connection Failed: ' . $e->getMessage();
        }

        echo 'end';
    }

    public function logout()
    {
        echo 'logout';
    }
}
