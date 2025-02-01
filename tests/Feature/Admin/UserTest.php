<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // 管理者とユーザーの作成
        $this->admin = Admin::factory()->create();
        $this->user = User::factory()->create();
    }

    public function test_guest_cannot_access_user_index()
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_normal_user_cannot_access_user_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.users.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_access_user_index()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.users.index'));
        $response->assertOk();
    }

    public function test_guest_cannot_access_user_show()
    {
        $response = $this->get(route('admin.users.show', $this->user));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_normal_user_cannot_access_user_show()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.users.show', $this->user));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_access_user_show()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.users.show', $this->user));
        $response->assertOk();
    }

    // public function test_guest_can_not_access_index(): void
    // {
    //     $response = $this->get(route('admin.users.index'));

    //     $response->assertRedirect(route('login'));
    // }

    // public function test_users_can_not_access_index(): void
    // {
    //     $user = User::factory()->create([
    //         'is_admin' => false
    //     ]);

    //     $response = $this->actingAs($user)
    //         ->get(route('admin.users.index'));

    //     $response->assertForbidden();
    // }

    // public function test_admins_can_access_index(): void
    // {
    //     $admin = User::factory()->create([
    //         'is_admin' => true
    //     ]);

    //     $response = $this->actingAs($admin)
    //         ->get(route('admin.users.index'));

    //     $response->assertOk();
    // }
}
