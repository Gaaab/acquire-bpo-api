<?php

namespace Acquire\Modules\Customer;

use Acquire\Modules\Customer\Models\Customer;
use App\Http\Controllers\Controller;
use Acquire\Modules\Customer\Requests\{CreateCustomerRequest, UpdateCustomerRequest};
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function __construct(protected CustomerService $customerService) {}

    public function getAllWithPagination(Request $request)
    {
        return $this->customerService->getAllWithPagination();
    }

    public function getAll()
    {
        return $this->customerService->getAll();
    }

    public function createCustomer(CreateCustomerRequest $request)
    {
        return $this->customerService->createCustomer($request->validated());
    }

    public function updateCustomer(Customer $customer, UpdateCustomerRequest $request)
    {
        return $this->customerService->updateCustomer($customer, $request->validated());
    }

    public function removeCustomer(Customer $customer)
    {
        return $this->customerService->removeCustomer($customer);
    }
}
