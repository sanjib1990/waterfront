<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class ApiMiddleware
 *
 * @package App\Http\Middleware
 */
class ApiMiddleware
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
        if (! in_array('api', $request->segments())) {
            return response()->jsend(null, trans('api.invalid_url_type'), 500);
        }

        if (! $request->isJson()) {
            return response()->jsend(null, trans('api.invalid_content_type'), 406);
        }

        if ($request->headers->get('accept') !== "application/json") {
            return response()->jsend(null, trans('api.invalid_accept_header'), 406);
        }

        if (! $this->validJson($request->getContent())) {
            return response()->jsend(null, trans('api.invalid_request_body'), 415);
        }

        return $next($request);
    }

    /**
     * Checks if the passed value is a valid json
     *
     * @param $json
     * @return bool
     */
    private function validJson($json)
    {
        if (empty($json) || (is_array(json_decode($json, true)) && json_last_error() == JSON_ERROR_NONE)) {
            return true;
        }

        return false;
    }
}
