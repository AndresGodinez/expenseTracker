<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot delete incomes', function () {
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->delete(route('incomes.destroy', $income));

    $response->assertRedirect(route('login'));
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('authenticated users can delete incomes', function () {
    $user = User::factory()->create();
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->delete(route('incomes.destroy', $income));

    $response->assertRedirect(route('incomes.index'));

    $this->assertDatabaseMissing('incomes', [
        'id' => $income->id,
    ]);
})->skip('Legacy incomes scaffold replaced by category-incomes.');
