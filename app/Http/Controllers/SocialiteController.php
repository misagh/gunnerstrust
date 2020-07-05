<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller {

    public function login()
    {
        if (! request()->has('nb'))
        {
            session()->put('socialite_back', url()->previous());
        }

        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try
        {
            $user = Socialite::driver('google')->stateless()->user();

            $email = $user->getEmail();
            $name = $user->getName();

            $user = (new UserRepository)->findBy('email', $email);

            if (empty($user))
            {
                $user = (new UserRepository)->create(compact('name', 'email'));
            }

            auth()->login($user, true);

            return redirect(session('socialite_back') ?: route('home'));
        }
        catch (\Exception $e)
        {
            // pass
        }

        return redirect()->to('/login');
    }
}
