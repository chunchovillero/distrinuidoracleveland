<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_an_active_administrator_can_enter_the_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
    }

    public function test_an_administrator_cannot_open_the_system_configuration(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/configuration');

        $response->assertForbidden();
        $this->assertAuthenticatedAs($admin);
    }

    public function test_an_administrator_cannot_open_user_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertForbidden();
        $this->assertAuthenticatedAs($admin);
    }

    public function test_a_superadministrator_can_open_the_system_configuration(): void
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'active' => true,
        ]);

        $response = $this->actingAs($superadmin)->get('/admin/configuration');

        $response->assertOk();
    }

    public function test_a_seller_is_logged_out_when_trying_to_enter_the_panel(): void
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'active' => true,
        ]);

        $response = $this->actingAs($seller)->get('/admin');

        $response->assertForbidden();
        $response->assertSee('Acceso denegado');
        $this->assertGuest();
    }

    public function test_a_seller_cannot_log_in_to_the_panel(): void
    {
        User::factory()->create([
            'email' => 'vendedor@pos.com',
            'password' => 'vendedor123',
            'role' => 'seller',
            'active' => true,
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'vendedor@pos.com',
            'password' => 'vendedor123',
        ]);

        $response->assertForbidden();
        $response->assertSee('Acceso denegado');
        $this->assertGuest();
    }
}
