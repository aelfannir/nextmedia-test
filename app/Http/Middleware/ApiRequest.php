<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

/**
 * Class ApiRequest
 * @package App\Http\Middleware
 */
class ApiRequest
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
        if ($request->has('meta')) {
            if (is_string($request->get('meta'))) {
                $meta = json_decode($request->get('meta'), true); // {}
                $request->merge(['meta'=>$meta]);
            }
        }

        if ($request->has('categoriesIds') && is_string($request->categoriesIds)) {
            $ids = json_decode($request->categoriesIds);// '[1,2]'
            $request->merge(['categoriesIds'=>$ids]);
        }

        return $next($request);
    }
}
