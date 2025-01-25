<?php

namespace Acquire\Modules\Auth;

use Acquire\Modules\Auth\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }
}
