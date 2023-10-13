<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu chưa login -> Login
        if (!auth()->check())
            return redirect()->route("login");

        // Nếu login rồi mà không phải admin -> 404
        if (auth()->user()->role != 3)
            return redirect()->to("404");

        return $next($request);
    }
}
