<?php

namespace Acquire\Modules\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Users', description: 'Operations related to users')]
class UsersController extends Controller
{
    #[Route('/api/user/self', methods: ['GET'], name: 'get_self')]
    #[OA\Get(
        path: '/api/user/self',
        summary: 'Retrieve authenticated user details',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                description: 'Media type expected by the client',
                schema: new OA\Schema(type: 'string', example: 'application/json')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User details retrieved successfully',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Example'),
                        new OA\Property(property: 'email', type: 'string', example: 'user123@example.com'),
                        new OA\Property(property: 'email_verified_at', type: 'string', format: 'date-time', example: '2024-09-15 04:44:06'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-09-15 04:44:06'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-09-15 04:44:06')
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized - Invalid or missing token'
            )
        ],
        security: [
            'sanctum' => [
                'bearerAuth' => []
            ]
        ]
    )]
    public function selfRequest(Request $request)
    {
        return $request->user();
    }
}
