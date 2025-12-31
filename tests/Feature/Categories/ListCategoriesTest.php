<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view categories', function () {
    $response = $this->get(route('categories.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view categories ordered by name', function () {
    $user = User::factory()->create();

    $zeta = \App\Models\Category::create(['name' => 'Zeta']);
    $alpha = \App\Models\Category::create(['name' => 'Alpha']);
    $beta = \App\Models\Category::create(['name' => 'Beta']);

    $response = $this->actingAs($user)->get(route('categories.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('categories/Index')
        ->has('categories', 3)
        ->where('create_url', route('categories.create', absolute: false))
        ->where('categories.0.name', 'Alpha')
        ->where('categories.0.edit_url', route('categories.edit', $alpha, absolute: false))
        ->where('categories.0.destroy_url', route('categories.destroy', $alpha, absolute: false))
        ->where('categories.1.name', 'Beta')
        ->where('categories.1.edit_url', route('categories.edit', $beta, absolute: false))
        ->where('categories.1.destroy_url', route('categories.destroy', $beta, absolute: false))
        ->where('categories.2.name', 'Zeta')
        ->where('categories.2.edit_url', route('categories.edit', $zeta, absolute: false))
        ->where('categories.2.destroy_url', route('categories.destroy', $zeta, absolute: false))
    );
});
