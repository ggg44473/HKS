<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeNewUser;
use App\Avatar;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after login.
     * 如果沒有定義此方法，會使用$redirectTo
     * 詳見 RedirectsUsers
     *
     * @return string
     */
    public function redirectTo()
    {
        return "user/" . auth()->user()->id . "/okr";
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        if (isset($data['avatar'])) {
            $file = $data['avatar'];
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            if ($user->avatar()->first()) {
                $avatar = $user->avatar()->first();
            } else {
                $attr['model_id'] = $user->id;
                $attr['model_type'] = get_class($user);
                $avatar = Avatar::create($attr);
            }
            $avatar->update(['path' => '/storage/avatar/' . $avatar->id . '/' . $filename]);
            $file->storeAs('public/avatar/' . $avatar->id, $filename);
        }

        if (is_a($user, User::class)) {
            Mail::to($user)
                ->queue(new WelcomeNewUser($user));
        }

        return $user;
    }
}
