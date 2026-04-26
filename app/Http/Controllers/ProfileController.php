<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{



    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }



    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }




    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);
        
       if ($request->hasFile('profile_picture')) {
            \Log::info('Profile picture file detected');
            

            if ($user->profile_picture && file_exists(public_path('images/profile_pictures/' . $user->profile_picture))) {
                unlink(public_path('images/profile_pictures/' . $user->profile_picture));
                \Log::info('Old profile picture deleted: ' . $user->profile_picture);
            }

            $file = $request->file('profile_picture');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            

            $targetDir = public_path('images/profile_pictures');
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
                \Log::info('Directory created: ' . $targetDir);
            }
            

            try {
                if ($file->move($targetDir, $filename)) {
                    $validated['profile_picture'] = $filename;
                    \Log::info('Profile picture uploaded successfully: ' . $filename);
                } else {
                    \Log::error('Failed to move profile picture - move() returned false');
                }
            } catch (\Exception $e) {
                \Log::error('Exception during file move: ' . $e->getMessage());
            }
        } else {
            \Log::info('No profile picture file uploaded');
        }
        

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            
            $user->password = Hash::make($request->new_password);
            $user->save();
            \Log::info('Password updated successfully for user: ' . $user->id);
        }
        

        unset($validated['current_password'], $validated['new_password'], $validated['new_password_confirmation']);
        
        $user->update($validated);
        \Log::info('Profile updated successfully with data: ' . json_encode($validated));

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}
