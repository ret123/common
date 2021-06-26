<?php

namespace Microservices;

use Closure;
use Illuminate\Http\Request;

class InfluencerScope
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function handle(Request $request, Closure $next)
    {
        if ($this->userService->isInfluencer()) {
            return $next($request);
        }
        throw new AuthenticationException;
    }
}
