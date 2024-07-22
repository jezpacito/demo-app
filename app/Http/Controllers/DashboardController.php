<?php

namespace App\Http\Controllers;

use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $availableIn = RateLimiter::availableIn($user->id, $user::RATELIMIT_ATTEMPT);
        $count = RateLimiter::retriesLeft($user->id, $user::RATELIMIT_ATTEMPT);

        return Inertia::render('Dashboard', [
            'count' => $count,
            'availableIn' => CarbonInterval::seconds($availableIn)->cascade()->forHumans(),
        ]);
    }
}
