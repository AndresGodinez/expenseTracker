<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view edit account page', function () {
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->get(route('accounts.edit', $account));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view edit account page', function () {
    $user = User::factory()->create();
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->actingAs($user)->get(route('accounts.edit', $account));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('accounts/Edit')
        ->where('account.id', $account->id)
        ->where('account.name', 'Checking')
        ->where('account.update_url', route('accounts.update', $account, absolute: false))
        ->where('index_url', route('accounts.index', absolute: false))
    );
});

test('guests cannot update accounts', function () {
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->put(route('accounts.update', $account), [
        'name' => 'Savings',
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can update accounts', function () {
    $user = User::factory()->create();
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->actingAs($user)->put(route('accounts.update', $account), [
        'name' => 'Savings',
    ]);

    $response->assertRedirect(route('accounts.index'));

    $this->assertDatabaseHas('accounts', [
        'id' => $account->id,
        'name' => 'Savings',
    ]);
});

test('account name is required when updating', function () {
    $user = User::factory()->create();
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->actingAs($user)->put(route('accounts.update', $account), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('account name must be less than 30 characters when updating', function () {
    $user = User::factory()->create();
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->actingAs($user)->put(route('accounts.update', $account), [
        'name' => str_repeat('a', 30),
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('account name must be unique when updating', function () {
    $user = User::factory()->create();

    $a = \App\Models\Account::create(['name' => 'Checking']);
    $b = \App\Models\Account::create(['name' => 'Savings']);

    $response = $this->actingAs($user)->put(route('accounts.update', $b), [
        'name' => 'Checking',
    ]);

    $response->assertSessionHasErrors(['name']);

    $this->assertDatabaseHas('accounts', [
        'id' => $b->id,
        'name' => 'Savings',
    ]);
});

test('updating an account with its current name is allowed', function () {
    $user = User::factory()->create();
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->actingAs($user)->put(route('accounts.update', $account), [
        'name' => 'Checking',
    ]);

    $response->assertRedirect(route('accounts.index'));
});
