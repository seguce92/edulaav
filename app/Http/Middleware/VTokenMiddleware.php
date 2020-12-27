<?php

namespace App\Http\Middleware;

use Closure;
use App\Resources\Resource;

class VTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('seguce92.data.service.vtoken') != $request->header('v-token-api'))
            return ( new Resource(collect([
                    'status'    =>  423,
                    'message'   => 'Ups. Lo siento no tienes acceso a esta petición.'
                ])))
                ->response()
                ->setStatusCode(423);

        return $next($request);
    }
}
