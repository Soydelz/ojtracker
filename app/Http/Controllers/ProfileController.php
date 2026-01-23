<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page
     */
    public function index()
    {
        return view('profile.index', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'school' => ['nullable', 'string', 'max:255'],
            'required_hours' => ['nullable', 'numeric', 'min:1', 'max:2000'],
            'face_descriptor' => ['nullable', 'string'],
        ]);

        // Check if email changed
        $emailChanged = $user->email !== $validated['email'];

        // Update user
        $user->update($validated);

        // If email changed, reset verification
        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();
            
            return redirect()->route('profile.index')
                ->with('warning', 'Profile updated successfully. Please verify your new email address.');
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update password
        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password changed successfully!');
    }

    /**
     * Upload profile picture
     */
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = auth()->user();

        // Delete old profile picture if exists
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Store new profile picture
        $path = $request->file('profile_picture')->store('profiles', 'public');
        
        $user->update(['profile_picture' => $path]);

        return redirect()->route('profile.index')
            ->with('success', 'Profile picture updated successfully!');
    }

    /**
     * Upload cover photo
     */
    public function uploadCoverPhoto(Request $request)
    {
        $request->validate([
            'cover_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        $user = auth()->user();

        // Delete old cover photo if exists
        if ($user->cover_photo && Storage::disk('public')->exists($user->cover_photo)) {
            Storage::disk('public')->delete($user->cover_photo);
        }

        // Store new cover photo
        $path = $request->file('cover_photo')->store('covers', 'public');
        
        $user->update(['cover_photo' => $path]);

        return redirect()->route('profile.index')
            ->with('success', 'Cover photo updated successfully!');
    }

    /**
     * Register face descriptor
     */
    public function registerFace(Request $request)
    {
        $request->validate([
            'face_descriptor' => ['required', 'string'],
        ]);

        $user = auth()->user();
        
        $user->update([
            'face_descriptor' => $request->face_descriptor
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Face registered successfully!'
        ]);
    }
}
