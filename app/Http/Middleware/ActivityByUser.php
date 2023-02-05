<?php
namespace App\Http\Middleware;
use App\Models\User;
use Closure;

use Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
class ActivityByUser
{
    public function handle($request, Closure $next)
    {

        if (Auth()->check()) {
            $agent = new Agent();
            if ($agent->isMobile() || $agent->isTablet())
            $dev='موبايل'; else $dev='كمبيوتر';
            $expiresAt = Carbon::now()->addMinutes(1); // keep online for 1 min
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
            // last seen
            User::where('id', Auth::user()->id)
                ->update([
                    'last_seen' => (new \DateTime())->format("Y-m-d H:i:s"),
                    'DevType'=>$dev]);
        }
        return $next($request);
    }
}
