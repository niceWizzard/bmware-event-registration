<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_user_can_login(): void
    {
        $user = self::createUser();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'pp',
        ]);
        $this->assertAuthenticated();
    }

    public function test_only_guest_can_access_login(): void
    {
        $user = self::createUser();
        $this->actingAs($user)->get(route('login'))->assertRedirect(route('home'));
    }

    public function test_logout(): void
    {
        $user = self::createUser();
        $this->actingAs($user);
        $this->post(route('logout'));
        $this->assertGuest();
    }

    private static function createUser(): User
    {
        return User::factory()->create([
            'password' => Hash::make('pp'),
        ]);
    }
}
