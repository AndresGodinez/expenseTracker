<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can create a category', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('categories.store'), [
        'name' => 'Food',
    ]);

    $response->assertRedirect(route('categories.index'));
    $this->assertDatabaseHas('categories', [
        'name' => 'Food',
    ]);
});

test('category name is required', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('categories.store'), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('category name must be unique', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->post(route('categories.store'), [
        'name' => 'Food',
    ]);

    $response = $this->post(route('categories.store'), [
        'name' => 'Food',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('category name must be at most 100 characters', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('categories.store'), [
        'name' => str_repeat('a', 101),
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('guests cannot create categories', function () {
    $response = $this->post(route('categories.store'), [
        'name' => 'Food',
    ]);

    $response->assertRedirect(route('login'));
});
