<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Accept student_token as a custom header for the Authorization Bearer token
        if ($token = $request->header('student_token')) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        // Force JSON response for all API requests
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
