<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TumaWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['tuma.api_key' => 'test-webhook-key']);
    }

    public function test_webhook_is_not_blocked_by_csrf_and_rejects_missing_key(): void
    {
        // Before the CSRF exclusion this redirected to /login ("Session expired")
        // without ever reaching the controller.
        $this->postJson('/webhook/tuma', ['order_id' => 'X1'])
            ->assertStatus(403)
            ->assertJson(['message' => 'Unauthorized']);
    }

    public function test_webhook_rejects_wrong_key(): void
    {
        $this->postJson('/webhook/tuma', ['order_id' => 'X1'], ['X-API-Key' => 'wrong'])
            ->assertStatus(403);
    }

    public function test_webhook_accepts_callback_with_valid_key(): void
    {
        $this->postJson('/webhook/tuma', ['order_id' => 'UNKNOWN-ORDER'], ['X-API-Key' => 'test-webhook-key'])
            ->assertOk()
            ->assertJson(['success' => true]);
    }
}
