<?php

namespace Agriserv\Departments\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySecretToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = config('departments.secret_token');

        if (empty($secret) || $request->header('X-Token') !== $secret) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        return $next($request);
    }
}
