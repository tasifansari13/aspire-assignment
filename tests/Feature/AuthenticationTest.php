<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::factory()->create();
        $formData = ['email' => $user->email, 'password' => 'password'];
        $this->json('POST', route('auth.login'), $formData)->assertStatus(200);
    }

    public function test_register()
    {
        $formData = ['name' => 'Unique User', 'email' => 'user@unique.com', 'password' => 'password', 'password_confirmation' => 'password'];
        $this->json('POST', route('auth.register'), $formData)->assertStatus(200);
    }
}
