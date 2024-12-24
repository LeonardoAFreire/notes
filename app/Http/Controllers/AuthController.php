<?php

namespace App\Http\Controllers;

use App\Models\User;
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


        // get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check if user exists

        $user = User::where('username', $username)
            ->where('deleted_at', NULL)
            ->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Wrong username or password.');
        }

        // if password is correct.
        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Wrong username or password.');
        }

        // update last login
        $user->last_login = now();
        $user->save();

        // login user
        session(['user' => [
            'id' => $user->id,
            'username' => $user->username
        ]]);

        echo 'Login com sucesso';
    }

    public function logout()
    {
        // logout from the application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
