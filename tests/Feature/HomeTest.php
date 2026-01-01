<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests can visit the home page', function () {
    $response = $this->get(route('home'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Home')
        ->where('sales_email', 'ventas@carvaz.com')
        ->has('login_url')
        ->has('register_url')
        ->has('dashboard_url')
        ->has('can_register')
    );
});

test('authenticated users are redirected from home to dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('home'));

    $response->assertRedirect(route('dashboard'));
});
