<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider pages
     */
    public function test_public_page_loads(string $path): void
    {
        $this->get($path)->assertOk();
    }

    public static function pages(): array
    {
        return [
            'home' => ['/'],
            'login' => ['/login'],
            'register' => ['/register'],
            'garages' => ['/garages'],
            'events' => ['/events'],
            'spare parts' => ['/spareparts'],
        ];
    }
}
