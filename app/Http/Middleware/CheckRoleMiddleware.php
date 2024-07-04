<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->level == 'Admin')
        {
            return $next($request);
        } elseif (Auth::user()->level == 'Petugas') {
            return redirect()->route('petugas');
        }
        return redirect()->route('pemesanan.index');
    }
}
