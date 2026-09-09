<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'city'     => 'nullable|string|max:100',
            'bio'      => 'nullable|string|max:1000',
            'avatar'   => 'nullable|image|max:2048',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $data = $request->only('name', 'phone', 'city', 'bio');

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('s3')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 's3');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', '¡Perfil actualizado exitosamente!');
    }

    public function investors()
    {
        $investors = User::where('role', 'investor')
            ->withCount('investments')
            ->orderByDesc('investments_count')
            ->paginate(20);

        return view('entrepreneur.investors', compact('investors'));
    }
}
