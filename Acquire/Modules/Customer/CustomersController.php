<?php

namespace Acquire\Modules\Customer;

use Acquire\Modules\Customer\Models\Customer;
use App\Http\Controllers\Controller;
use Acquire\Modules\Customer\Requests\{CreateCustomerRequest, UpdateCustomerRequest};
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Customers', description: 'Operations related to customers')]
class CustomersController extends Controller
{
    public function __construct(protected CustomerService $customerService) {}

    public function getAllWithPagination(Request $request)
    {
        return $this->customerService->getAllWithPagination();
    }

    #[Route('/api/customers', methods: ['GET'], name: 'get_all_customers')]
    #[OA\Get(
        path: '/api/customers',
        summary: 'Retrieve all customers',
        tags: ['Customers'],
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
                description: 'All customers retrieved successfully',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', example: 1),
                            new OA\Property(property: 'first_name', type: 'string', example: 'Customer First Name.'),
                            new OA\Property(property: 'last_name', type: 'string', example: 'Customer Last Name'),
                            new OA\Property(property: 'email', type: 'string', example: 'customer@sample.com'),
                            new OA\Property(property: 'age', type: 'int', example: 32),
                            new OA\Property(property: 'dob', type: 'string', example: '2025-01-01'),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorize - User does not exists',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'The following user does not exists.')
                    ]
                )
            ),
        ],
        security: [
            'sanctum' => [
                'bearerAuth' => []
            ]
        ]
    )]
    public function getAll()
    {
        return $this->customerService->getAll();
    }

    #[Route('/api/customers', methods: ['POST'], name: 'create_customers')]
    #[OA\Post(
        path: '/api/customers',
        summary: 'Create a new customers',
        tags: ['Customers'],
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
            description: 'Customer details',
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 1),
                    new OA\Property(property: 'first_name', type: 'string', example: 'Customer First Name.'),
                    new OA\Property(property: 'last_name', type: 'string', example: 'Customer Last Name'),
                    new OA\Property(property: 'email', type: 'string', example: 'customer@sample.com'),
                    new OA\Property(property: 'age', type: 'int', example: 32),
                    new OA\Property(property: 'dob', type: 'string', example: '2025-01-01'),
                    new OA\Property(property: 'creation_date', type: 'string', example: '2025-01-01'),
                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '0000-00-00 00:00:00'),
                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '0000-00-00 00:00:00'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Returns the Customer Model Object'),
            new OA\Response(response: 422, description: 'Customer Create Validation Error'),
        ],
        security: [
            'sanctum' => [
                'bearerAuth' => []
            ]
        ]
    )]
    public function createCustomer(CreateCustomerRequest $request)
    {
        return $this->customerService->createCustomer($request->validated());
    }

    #[Route('/api/customers/update/{customer}', methods: ['PUT'], name: 'update_customer')]
    #[OA\Put(
        path: '/api/customers/update/{customer}',
        summary: 'Update a customer by ID',
        tags: ['Customers'],
        parameters: [
            new OA\Parameter(
                name: 'customer',
                in: 'path',
                required: true,
                description: 'ID of the customer to update',
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                description: 'Media type expected by the client',
                schema: new OA\Schema(type: 'string', example: 'application/json')
            )
        ],
        requestBody: new OA\RequestBody(
            description: 'Customer update details',
            required: true,
            content: new OA\JsonContent(

                type: 'object',
                properties: [
                    new OA\Property(property: 'first_name', type: 'string', example: 'Customer Updated First Name'),
                    new OA\Property(property: 'last_name', type: 'string', example: 'Customer Updated Last Name'),
                    new OA\Property(property: 'email', type: 'string', example: 'customer-update@example.com'),
                    new OA\Property(property: 'age', type: 'int', example: 32),
                    new OA\Property(property: 'dob', type: 'string', example: '2025-01-01'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Customer status updated successfully'),
            new OA\Response(response: 404, description: 'Customer model not found'),
            new OA\Response(response: 422, description: 'Validation Content Error'),
        ],
        security: [
            'sanctum' => [
                'bearerAuth' => []
            ]
        ]
    )]
    public function updateCustomer(Customer $customer, UpdateCustomerRequest $request)
    {
        return $this->customerService->updateCustomer($customer, $request->validated());
    }

    #[Route('/api/customers/{post}/archive', methods: ['DELETE'], name: 'delete_customer')]
    #[OA\Delete(
        path: '/api/customers/{post}',
        summary: 'Delete a customer by ID',
        tags: ['Customers'],
        parameters: [
            new OA\Parameter(
                name: 'customer',
                in: 'path',
                required: true,
                description: 'ID of the post to be archived',
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                description: 'Media type expected by the client',
                schema: new OA\Schema(type: 'string', example: 'application/json')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Customer removed successfully'),
            new OA\Response(response: 404, description: 'No query results for model Post'),
            new OA\Response(response: 422, description: 'Record Deletion Error'),
        ],
        security: [
            'sanctum' => [
                'bearerAuth' => []
            ]
        ]
    )]
    public function removeCustomer(Customer $customer)
    {
        return $this->customerService->removeCustomer($customer);
    }
}
