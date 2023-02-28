<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }

    public function update()
    {
        $user = auth()->user();

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'current_password' => ['required_with:password', function($attribute, $value, $fail) use ($user){
                return Hash::check($value, $user->password) ? true : $fail('Current password is not correct!');
            }],
        ]);

        $userUpdate = [];

        $userUpdate['name'] = $data['name'];
        $userUpdate['username'] = $data['username'];
        $userUpdate['email'] = $data['email'];

        if(!empty($data['password'])) $userUpdate['password'] = Hash::make($data['password']);

        $user->update($userUpdate);

        return redirect()->back()->with('success', 'User profile updated successfully.');
    }
}
