<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    private const ROLE_SUPERADMIN = 1;
    private const ROLE_ADMIN = 2;
    private const ROLE_USER = 3;

    private const ADMIN_PAGES = [
        '/admin/role',
        '/admin/permission',
        '/admin/invoice',
        '/admin/listing',
        '/admin/package',
        '/admin/category',
        '/admin/carmake',
        '/admin/city',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function userWithRole(int $roleId): User
    {
        $user = User::factory()->create();
        $user->roles()->sync([$roleId]);

        return $user;
    }

    public function test_guests_are_redirected_to_login(): void
    {
        foreach (self::ADMIN_PAGES as $page) {
            $this->get($page)->assertRedirect('/login');
        }
    }

    public function test_regular_users_are_forbidden_from_admin_pages(): void
    {
        $user = $this->userWithRole(self::ROLE_USER);

        foreach (self::ADMIN_PAGES as $page) {
            $this->actingAs($user)->get($page)->assertForbidden();
        }
    }

    public function test_regular_users_cannot_update_invoices(): void
    {
        $user = $this->userWithRole(self::ROLE_USER);
        $invoice = Invoice::create([
            'invoice_no' => 'INV-TEST',
            'total' => 1000,
            'paid' => 0,
            'status' => 'unpaid',
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->put("/admin/invoice_update/{$invoice->id}", ['status' => 'paid', 'paid' => 1000])
            ->assertForbidden();

        $this->assertSame('unpaid', $invoice->fresh()->status);
    }

    public function test_admins_and_superadmins_can_open_admin_pages(): void
    {
        foreach ([self::ROLE_ADMIN, self::ROLE_SUPERADMIN] as $roleId) {
            $admin = $this->userWithRole($roleId);

            foreach (self::ADMIN_PAGES as $page) {
                $this->actingAs($admin)->get($page)->assertOk();
            }
        }
    }
}
