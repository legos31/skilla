<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Faker\Factory as Faker;


class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_index_returns_a_json_data(): void
    {
        $response = $this->json('GET', '/api/users');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_success_create_user(): void
    {
        Event::fake();
        $faker = Faker::create();
        $name = $faker->name();
        $email = $faker->unique()->safeEmail();

        $response = $this->postJson('/api/users',
            [
                'name' => $name,
                'email' => $email,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'name',
                    'email',
                    'updated_at',
                    'created_at',
                ],
                'token'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
    }

    public function test_show_user_by_id(): void
    {
        $response = $this->getJson('/api/users/3');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ]);
    }

    public function test_success_update_user(): void
    {
        $faker = Faker::create();
        $name = $faker->name();

        $response = $this->patchJson('/api/users/3',
            [
                'name' => $name,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $name,
            ]);
    }


}
