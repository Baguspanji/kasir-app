<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $auth)
    {
        $authLevel = [
            'employee' => [
                'admin',
                'employee',
            ],
            'admin' => [
                'admin',
            ],
        ];

        $authLevels = [];
        foreach (explode('-', $auth) as $key => $value) {
            if ($key == 0) {
                $authLevels = $authLevel[$value] ?? [];
            } else {
                foreach ($authLevel[$value] ?? [] as $role) {
                    array_push($authLevels, $role);
                }
                // array_merge($authLevels, $authLevel[$value] ?? []);
            }
        }

        $inRole = false;
        if (in_array(auth()->user()->role, $authLevels)) {
            $inRole = true;
        }

        if (!$inRole) {
            return abort(401);
        }

        return $next($request);
    }
}
