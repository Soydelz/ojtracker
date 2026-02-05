<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log errors to stderr so they appear in Render logs
            error_log("LARAVEL ERROR: " . $e->getMessage());
            error_log("FILE: " . $e->getFile() . " LINE: " . $e->getLine());
        });
    }
    
    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Always show detailed errors for debugging
        if (config('app.debug') || env('APP_DEBUG') === 'true' || env('APP_DEBUG') === true) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
        
        return parent::render($request, $e);
    }
}
