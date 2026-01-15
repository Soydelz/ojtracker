<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\User;

class EmailVerificationController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        // Check if email is already registered
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already registered. Please use a different email or login.'
            ], 422);
        }

        $email = $request->email;
        
        // Generate 6-digit verification code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code in cache for 10 minutes
        Cache::put('verification_code_' . $email, $code, now()->addMinutes(10));
        
        try {
            // Send email with verification code using HTML template
            Mail::send('emails.verification-code', ['code' => $code], function ($message) use ($email) {
                $message->to($email)
                        ->subject('OJTracker - Email Verification Code');
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Verification code sent successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification code: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        $email = $request->email;
        $code = $request->code;
        
        // Get stored code from cache
        $storedCode = Cache::get('verification_code_' . $email);
        
        if (!$storedCode) {
            return response()->json([
                'success' => false,
                'message' => 'Verification code has expired. Please request a new one.'
            ], 400);
        }
        
        if ($storedCode !== $code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code. Please try again.'
            ], 400);
        }
        
        // Mark email as verified in cache (valid for 30 minutes)
        Cache::put('email_verified_' . $email, true, now()->addMinutes(30));
        
        // Remove the verification code
        Cache::forget('verification_code_' . $email);
        
        // Send confirmation email
        try {
            Mail::send('emails.email-verified', [], function ($message) use ($email) {
                $message->to($email)
                        ->subject('OJTracker - Email Verified Successfully');
            });
        } catch (\Exception $e) {
            \Log::error('Confirmation email failed: ' . $e->getMessage());
            // Don't fail the verification if confirmation email fails
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
    }
}
