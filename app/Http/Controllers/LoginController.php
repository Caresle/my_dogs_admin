<?php

namespace App\Http\Controllers;

use App\Http\Helpers\JwtHandler;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class LoginController extends Controller
{
    public function index() {
        return Inertia::render('Login/Login');
    }

    public function store(Request $request) {
        $request->validate([
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:3',
        ]);

        $json = json_decode($request->getContent());

        $user = User::where([
            ['username', '=', $json->username],
        ])->first();

        if (!isset($user))
            return back()->withErrors(['general' => 'Check the given information']);

        if (!password_verify($json->password, $user->password))
            return back()->withErrors(['general' => 'Check the given information']);

        // Check if the user status is active
        if ($user->status != 'S') {
            $user->status = 'S';
            $user->save();
        }

        $token = JwtHandler::createToken($user);
        session()->put('token', $token);

        return redirect()->to(route('dashboard'));
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->to(route('login'));
    }
}
