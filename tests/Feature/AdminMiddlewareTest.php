<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AdminMiddlewareTest extends TestCase
{
    /**
     * Test access to admin route with admin role.
     *
     * @return void
     */
    public function testAdminAccessWithAdminRole()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Authenticate as admin
        $this->actingAs($admin);

        // Access admin route
        $response = $this->get(route('admin.products'));

        // Assert the response is successful
        $response->assertStatus(200);
    }

    /**
     * Test access to admin route with non-admin role.
     *
     * @return void
     */
    public function testAdminAccessWithNonAdminRole()
    {
        // Create a non-admin user
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        // Authenticate as non-admin
        $this->actingAs($user);

        // Attempt to access admin route
        $response = $this->get(route('admin.products'));

        // Assert that access is denied
        $response->assertStatus(403);
    }


}
