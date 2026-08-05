<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'student@example.com',
            'password' => 'password',
            'role' => 'student',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_student_cannot_access_admin_only_route(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
        ]);

        $response = $this->actingAs($student)->get(route('courts.index'));

        $response->assertForbidden();
    }

    public function test_student_can_only_view_their_own_booking(): void
    {
        $owner = User::factory()->create(['role' => 'student']);
        $otherStudent = User::factory()->create(['role' => 'student']);

        $myBooking = Booking::create([
            'user_id' => $owner->id,
            'purpose' => 'Tập luyện cá nhân',
            'player_count' => 4,
            'contact_phone' => '0900123456',
            'status' => 'pending',
        ]);

        $otherBooking = Booking::create([
            'user_id' => $otherStudent->id,
            'purpose' => 'Giao lưu thể thao',
            'player_count' => 6,
            'contact_phone' => '0900111222',
            'status' => 'pending',
        ]);

        $this->actingAs($owner)
            ->get(route('bookings.show', $myBooking))
            ->assertOk();

        $this->actingAs($owner)
            ->get(route('bookings.show', $otherBooking))
            ->assertForbidden();
    }

    public function test_admin_can_open_report_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('reports.index'));

        $response->assertOk();
    }
}
