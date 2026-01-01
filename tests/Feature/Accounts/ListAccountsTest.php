<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view accounts', function () {
    $response = $this->get(route('accounts.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view accounts ordered by name', function () {
    $user = User::factory()->create();

    $zeta = \App\Models\Account::create(['name' => 'Zeta']);
    $alpha = \App\Models\Account::create(['name' => 'Alpha']);
    $beta = \App\Models\Account::create(['name' => 'Beta']);

    $response = $this->actingAs($user)->get(route('accounts.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('accounts/Index')
        ->has('accounts', 3)
        ->where('create_url', route('accounts.create', absolute: false))
        ->where('accounts.0.name', 'Alpha')
        ->where('accounts.0.edit_url', route('accounts.edit', $alpha, absolute: false))
        ->where('accounts.0.destroy_url', route('accounts.destroy', $alpha, absolute: false))
        ->where('accounts.1.name', 'Beta')
        ->where('accounts.1.edit_url', route('accounts.edit', $beta, absolute: false))
        ->where('accounts.1.destroy_url', route('accounts.destroy', $beta, absolute: false))
        ->where('accounts.2.name', 'Zeta')
        ->where('accounts.2.edit_url', route('accounts.edit', $zeta, absolute: false))
        ->where('accounts.2.destroy_url', route('accounts.destroy', $zeta, absolute: false))
    );
});
