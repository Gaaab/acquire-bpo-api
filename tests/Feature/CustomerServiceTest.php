<?php

namespace Tests\Feature;

use Acquire\Modules\Customer\CustomerService;
use Acquire\Modules\Customer\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CustomerService $customerService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerService = app(CustomerService::class);
    }

    /**
     * Test customer creation.
     */
    public function test_create_customer(): void
    {
        $data = [
            'first_name' => fake()->unique()->firstName(),
            'last_name' => fake()->unique()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'dob' => '1990-01-01',
            'age' => 33,
        ];

        $customer = $this->customerService->createCustomer($data);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertDatabaseHas('customer', ['email' => $data['email']]);
    }

    public function test_update_customer(): void
    {
        $customer = Customer::factory()->create();

        $email = fake()->unique()->safeEmail();

        $data = [
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'email' => $email,
        ];

        $updatedCustomer = $this->customerService->updateCustomer($customer, $data);

        $this->assertInstanceOf(Customer::class, $updatedCustomer);
        $this->assertDatabaseHas('customer', ['email' => $updatedCustomer->email]);
        $this->assertEquals($email, $updatedCustomer->email);
    }

    public function test_delete_customer(): void
    {
        $customer = Customer::factory()->create();

        $deletedCustomer = $this->customerService->removeCustomer($customer);

        $this->assertInstanceOf(Customer::class, $deletedCustomer);
        $this->assertDatabaseMissing('customer', ['id' => $deletedCustomer->id]);
    }
}
