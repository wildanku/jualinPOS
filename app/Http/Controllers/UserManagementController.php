<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = new User();
        
        if($request->q) {
            $users = $users->where('name','like','%'.$request->q.'%');
        }

        $users = $users->paginate($request->q ?? 20);

        return view('setting.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        DB::transaction(function() use($request) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'language' => $request->language,
                'timezone' => $request->timezone
            ]);
        });

        return redirect()->back()->with('success', 'User created!');
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        DB::transaction(function() use($request, $user) {
            $user->update($request->all());
        });

        return redirect()->back()->with('success', 'User created!');
    }

    public function updatePass(User $user, Request $request)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        DB::transaction(function() use($request, $user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        });

        return redirect()->back()->with('success', 'Password Updated!');
    }

    public function destroy(User $user)
    {
        if($user->id == auth()->user()->id) {
            return redirect()->back()->with('error','You are not allowed to delete this user');
        }

        DB::transaction(function() use($user) {
            $user->delete();
        });

        return redirect()->back()->with('success','User deleted');
    }
}
