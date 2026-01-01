<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can create an account', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('accounts.store'), [
        'name' => 'Checking',
    ]);

    $response->assertRedirect(route('accounts.index'));

    $this->assertDatabaseHas('accounts', [
        'name' => 'Checking',
    ]);
});

test('account name is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('accounts.store'), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('account name must be unique', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('accounts.store'), [
        'name' => 'Checking',
    ]);

    $response = $this->actingAs($user)->post(route('accounts.store'), [
        'name' => 'Checking',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('account name must be less than 30 characters', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('accounts.store'), [
        'name' => str_repeat('a', 30),
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('guests cannot create accounts', function () {
    $response = $this->post(route('accounts.store'), [
        'name' => 'Checking',
    ]);

    $response->assertRedirect(route('login'));
});
