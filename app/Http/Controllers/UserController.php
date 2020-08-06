<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\MessageRepository;

class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['list']]);
    }

    public function profile($username = null)
    {
        $profile = (new UserRepository)->findByUsername($username);

        if ($profile->id !== auth()->id())
        {
            $profile->increment('hits');
        }

        return view('users.profile', compact('profile'));
    }

    public function list()
    {
        $gunners = (new UserRepository)->getList();

        return view('users.list', compact('gunners'));
    }

    public function messages()
    {
        $messages = (new MessageRepository)->getList(auth()->id());

        return view('messages.list', compact('messages'));
    }

    public function edit()
    {
        $user = auth()->user();

        $rules = [
            'name'  => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
        ];

        $this->validate(request(), $rules);

        $user->update(request()->only(['name', 'email']));

        session()->flash('success', 'تغییرات با موفقیت ذخیره شد.');

        return redirect()->back();
    }

    public function username()
    {
        $user = auth()->user();

        if (empty($user->username))
        {
            if (request()->isMethod('post'))
            {
                $this->validate(request(), ['username' => ['required', 'string', 'min:3', 'max:15', 'username', 'unique:users']]);

                (new UserRepository)->update($user, ['username' => request('username')]);

                return redirect(session('socialite_back') ?: route('users.profile', request('username')));
            }

            return view('users.username');
        }

        return redirect()->route('users.profile', $user->username);
    }

    public function password()
    {
        $user = auth()->user();

        if (! empty($user->password) && ! Hash::check(request('password_current'), $user->password))
        {
            session()->flash('error', 'رمز عبور فعلی را اشتباه وارد کرده اید.');

            return redirect()->back();
        }

        $rules = ['password' => ['required', 'string', 'min:8', 'confirmed']];

        $this->validate(request(), $rules);

        $user->update(['password' => Hash::make(request('password'))]);

        session()->flash('success', 'تغییرات با موفقیت ذخیره شد. لطفا دوباره وارد سایت شوید.');

        auth()->logout();

        return redirect()->route('login');
    }
}
