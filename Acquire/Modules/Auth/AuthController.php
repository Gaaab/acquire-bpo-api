<?php

namespace Acquire\Modules\Auth;

use Acquire\Modules\Auth\Requests\LoginRequest;
use Acquire\Modules\User\Models\User;
use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Auth', description: 'Operations related to authentication')]
class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    #[Route('/api/auth/login', methods: ['POST'], name: 'login_user')]
    #[OA\Post(
        path: '/api/auth/login',
        summary: 'User login',
        tags: ['Auth'],
        parameters: [
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                description: 'Media type expected by the client',
                schema: new OA\Schema(type: 'string', example: 'application/json')
            )
        ],
        requestBody: new OA\RequestBody(
            description: 'Login credentials',
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'test@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login successful',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'token',
                            type: 'string',
                            example: 'JWT_TOKEN_HERE'
                        ),
                        new OA\Property(
                            property: 'token_type',
                            type: 'string',
                            example: 'Bearer'
                        ),
                        new OA\Property(
                            property: 'expires_at',
                            type: 'string',
                            example: '0000-00-00 00:00:00'
                        ),
                        new OA\Property(
                            property: 'user',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'int', example: '1'),
                                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'test@example.com'),
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Invalid credentials'
            )
        ]
    )]
    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }
}
