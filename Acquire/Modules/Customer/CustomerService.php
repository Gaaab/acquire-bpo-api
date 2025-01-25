<?php

namespace Acquire\Modules\Customer;

use Acquire\Modules\Customer\Models\Customer;
use Exception;

class CustomerService
{
    public function getAllWithPagination(array $options = [])
    {
        return Customer::query()
            ->orderBy($options['sortBy'] ?? 'id', $options['sortDirection'] ?? 'asc')
            ->paginate();
    }

    public function getAll()
    {
        return Customer::query()
            ->latest()
            ->get();
    }

    public function findById(int $id)
    {
        return Customer::findOrFail($id);
    }

    public function createCustomer(array $payload): Customer
    {
        return Customer::create($payload);
    }

    public function updateCustomer(Customer $customer, array $payload): Customer
    {
        $customer->update($payload);

        return $customer->fresh();
    }

    public function removeCustomer(Customer $customer): Customer
    {
        if (!$customer->delete()) {
            throw new Exception('Unable to delete customer error.', 422);
        }

        return $customer;
    }
}
