<?php

namespace App\Http\Middleware;

use App\Models\Paid;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class DeleteReserve
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $paids = Paid::where('status', 'reserve')->latest()->get();
        if ($paids) {
            foreach ($paids as $paid) {
                if ($paid->created_at->addDay() < Carbon::now()) {
                    $paid->delete();
                }
            }
        }

        return $next($request);
    }
}
