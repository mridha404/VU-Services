<?php

// tests/Feature/MyFeatureTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MyFeatureTest extends TestCase
{
    use RefreshDatabase; // This trait resets the database after each test method

    /** @test */
    public function it_returns_welcome_message()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Laravel');
    }

    /** @test */
    public function it_registers_user()
    {
        $user = User::factory()->create(); // Assuming you have a User model and a UserFactory

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function it_logs_in_user()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // Assuming the password is 'password'
        ]);

        $response->assertRedirect('/dashboard'); // Assuming successful login redirects to /dashboard
        $this->assertAuthenticatedAs($user);
    }
}
