<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\NotificationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class, 'alpha_dash', 'min:3'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'school' => ['required', 'string', 'max:255'],
            'required_hours' => ['required', 'integer', 'min:1', 'max:2000'],
        ]);

        // Check if email was verified (auto-verify in production to avoid SMTP issues)
        $emailVerified = \Cache::get('email_verified_' . $request->email);
        $isProduction = config('app.env') === 'production';
        
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'school' => $request->school,
            'required_hours' => $request->required_hours,
            'email_verified_at' => ($emailVerified || $isProduction) ? now() : null,
        ]);
        
        // Clear the verification cache
        \Cache::forget('email_verified_' . $request->email);

        event(new Registered($user));
        
        // Send welcome notification
        NotificationService::sendWelcomeNotification($user);

        // Don't auto-login, redirect back with success message
        return back()->with('registration_success', true);
    }
}
