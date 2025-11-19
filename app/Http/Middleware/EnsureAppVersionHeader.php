<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAppVersionHeader
{
    public function handle(Request $request, Closure $next, string $minimumVersion = '1.0.0'): Response
    {
        if (!$request->hasHeader('X-App-Version')) {
            return response()->json(['error' => 'X-App-Version header is required'], 400);
        }
        if (version_compare($request->header('X-App-Version'), $minimumVersion, '<')) {
            return response()->json(['error' => 'App version must be at least {$minimumVersion}.'], 400);
        }
        $response = $next($request);

        $response->header('X-Processed-By', 'Gemini-Middleware');

        return $response;
    }
}
