<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot delete categories', function () {
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->delete(route('categories.destroy', $category));

    $response->assertRedirect(route('login'));
});

test('authenticated users can delete categories', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::create(['name' => 'Food']);

    $response = $this->actingAs($user)->delete(route('categories.destroy', $category));

    $response->assertRedirect(route('categories.index'));
    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});
