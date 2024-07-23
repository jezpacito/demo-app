<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;
use Mockery;

class RateLimitPerHourMiddlewareTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function test_it_aborts_request_when_rate_limit_exceeded(): void
    {
        // Mock the RateLimiter::attempt method to simulate rate limit exceeded
        RateLimiter::shouldReceive('attempt')
        ->with($this->user->id, $this->user::RATELIMIT_ATTEMPT, \Mockery::type('callable'), $this->user::RATELIMIT_DURATION_IN_SECONDS)
            ->andReturn(false);

        $response = $this->actingAs($this->user)
            ->get('/dashboard');

        $response->assertStatus(429);
    }

}
