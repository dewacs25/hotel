<?php

namespace App\Http\Middleware;

use App\Models\Transaction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class expireMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $expiredData = Transaction::where('expire', '<=', Carbon::now())->where('status','pending')->get();
        if ($expiredData) {
            foreach ($expiredData as $data) {
                $data->delete();
                if (session('notif') == 1) {
                    session()->forget('notif');
                }else{
                    $notif = session('notif') - 1;
                    session()->put('notif',$notif);
                }
            }
        }
        return $next($request);
    }
}
