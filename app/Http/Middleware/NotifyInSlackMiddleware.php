<?php

namespace App\Http\Middleware;

use App\Jobs\NotifyInSlackJob;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotifyInSlackMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /* @var $response JsonResponse */
        $response = $next($request);

        if (!empty($response->exception) && $response->getStatusCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
            $location = $response->exception->getFile() . ':' . $response->exception->getLine();
            NotifyInSlackJob::dispatch($location, $response->exception->getMessage());
        }

        return $response;
    }
}
