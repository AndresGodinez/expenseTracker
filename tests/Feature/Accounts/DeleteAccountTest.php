<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot delete accounts', function () {
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->delete(route('accounts.destroy', $account));

    $response->assertRedirect(route('login'));
});

test('authenticated users can delete accounts', function () {
    $user = User::factory()->create();
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $response = $this->actingAs($user)->delete(route('accounts.destroy', $account));

    $response->assertRedirect(route('accounts.index'));

    $this->assertDatabaseMissing('accounts', [
        'id' => $account->id,
    ]);
});
