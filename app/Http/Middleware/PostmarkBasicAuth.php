<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostmarkBasicAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedUser = config('services.postmark.webhook_user');
        $expectedPassword = config('services.postmark.webhook_password');

        if (empty($expectedUser) || empty($expectedPassword)) {
            abort(503, 'Webhook auth is not configured.');
        }

        $user = $request->getUser();
        $password = $request->getPassword();

        $userMatches = is_string($user) && hash_equals((string) $expectedUser, $user);
        $passwordMatches = is_string($password) && hash_equals((string) $expectedPassword, $password);

        if (! ($userMatches && $passwordMatches)) {
            return response('Unauthorized', 401, ['WWW-Authenticate' => 'Basic realm="postmark"']);
        }

        return $next($request);
    }
}
