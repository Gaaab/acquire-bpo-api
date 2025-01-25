<?php

namespace Acquire\Modules\Auth;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $credentials, $remember = false): array
    {
        if (!Auth::attempt($credentials, $remember)) {
            throw new Exception('Error logging in...', 422);
        }

        $user = Auth::user();

        $tokenResult = $user->createToken('Personal Access Token');

        if ($remember) {
            $tokenResult->token->expires_at = Carbon::now()->addWeeks(1);
        }

        return [
            'token_type' => 'Bearer',
            'token' => $tokenResult->accessToken,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user
        ];
    }
}
