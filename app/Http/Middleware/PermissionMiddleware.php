<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null ): Response
    {        
        /**
         * Valido que el usuario tiene permiso
         */
        if( !$request->user()->can( $permission ) ) :
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Dont have permission.'
            ], Response::HTTP_FORBIDDEN );
        endif;

        return $next($request);
    }
}
