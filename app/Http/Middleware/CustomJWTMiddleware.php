<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\JsonResponse;

class CustomJWTMiddleware {
    public function handle($request, Closure $next): JsonResponse {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch(TokenExpiredException $e) {
            return response()->json(['message'=>'Token has expired'], 401);
        } catch(TokenInvalidException $e) {
            return response()->json(['message'=>'Invalid token', 'error'=> $e->getMessage()], 401);
        } catch(Exception $e) {
            return response()->json(['message'=>'Authorization token not found'], 401);
        }
        return $next($request);
    }
}