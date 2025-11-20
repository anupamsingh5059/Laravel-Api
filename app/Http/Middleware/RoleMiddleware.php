<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
      public function handle(Request $request, Closure $next, $roles) {
        // allow multiple roles: "admin|employee"
        $user = $request->user();
        if (! $user) {
            return response()->json(['message'=>'Unauthenticated'], 401);
        }
        $allowed = explode('|', $roles);
        if (! in_array($user->role, $allowed)) {
            // If AJAX request -> json, else redirect back
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403, 'Forbidden');
        }
        return $next($request);
    }
}
