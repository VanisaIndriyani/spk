<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('roles.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('roles.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'full_name' => 'required|string|max:255',
            'current_password' => 'required|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        // Update user data
        $updateData = [
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'updated_at' => now()
        ];

        // Update password if provided
        if (!empty($data['new_password'])) {
            $updateData['password'] = Hash::make($data['new_password']);
        }

        DB::table('users')->where('id', $user->id)->update($updateData);

        return redirect()->route('profile.index')->with('success', 'Profile berhasil diperbarui.');
    }
}
