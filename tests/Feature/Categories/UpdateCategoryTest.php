<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view edit category page', function () {
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->get(route('categories.edit', $category));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view edit category page', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->actingAs($user)->get(route('categories.edit', $category));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('categories/Edit')
        ->where('category.id', $category->id)
        ->where('category.name', 'Food')
        ->where('category.update_url', route('categories.update', $category, absolute: false))
    );
});

test('guests cannot update categories', function () {
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->put(route('categories.update', $category), [
        'name' => 'Groceries',
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can update categories', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->actingAs($user)->put(route('categories.update', $category), [
        'name' => 'Groceries',
    ]);

    $response->assertRedirect(route('categories.index'));

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Groceries',
    ]);
});

test('category name is required when updating', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->actingAs($user)->put(route('categories.update', $category), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('category name must be at most 100 characters when updating', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->actingAs($user)->put(route('categories.update', $category), [
        'name' => str_repeat('a', 101),
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('category name must be unique when updating', function () {
    $user = User::factory()->create();
    $categoryA = \App\Models\Category::create(['name' => 'Food']);
    $categoryB = \App\Models\Category::create(['name' => 'Transport']);

    $response = $this->actingAs($user)->put(route('categories.update', $categoryB), [
        'name' => 'Food',
    ]);

    $response->assertSessionHasErrors(['name']);

    $this->assertDatabaseHas('categories', [
        'id' => $categoryB->id,
        'name' => 'Transport',
    ]);
});

test('updating a category with its current name is allowed', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->actingAs($user)->put(route('categories.update', $category), [
        'name' => 'Food',
    ]);

    $response->assertRedirect(route('categories.index'));
});
