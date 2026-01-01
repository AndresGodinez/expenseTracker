<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view incomes', function () {
    $response = $this->get(route('incomes.index'));

    $response->assertRedirect(route('login'));
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('authenticated users can view incomes ordered by name', function () {
    $user = User::factory()->create();

    $zeta = \App\Models\Income::create(['name' => 'Zeta']);
    $alpha = \App\Models\Income::create(['name' => 'Alpha']);
    $beta = \App\Models\Income::create(['name' => 'Beta']);

    $response = $this->actingAs($user)->get(route('incomes.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Index')
        ->has('incomes', 3)
        ->where('create_url', route('incomes.create', absolute: false))
        ->where('incomes.0.name', 'Alpha')
        ->where('incomes.0.edit_url', route('incomes.edit', $alpha, absolute: false))
        ->where('incomes.0.destroy_url', route('incomes.destroy', $alpha, absolute: false))
        ->where('incomes.1.name', 'Beta')
        ->where('incomes.1.edit_url', route('incomes.edit', $beta, absolute: false))
        ->where('incomes.1.destroy_url', route('incomes.destroy', $beta, absolute: false))
        ->where('incomes.2.name', 'Zeta')
        ->where('incomes.2.edit_url', route('incomes.edit', $zeta, absolute: false))
        ->where('incomes.2.destroy_url', route('incomes.destroy', $zeta, absolute: false))
    );
})->skip('Legacy incomes scaffold replaced by category-incomes.');
