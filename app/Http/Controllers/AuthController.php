<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __invoke()
    {
        $email = request()->input('email');

        $user = User::firstOrCreate([
            'email' => $email
        ]);

        Auth::login($user);

        return redirect('/');
    }
}
