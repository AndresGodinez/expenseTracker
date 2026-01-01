<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view expenses', function () {
    $response = $this->get(route('expenses.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view expenses ordered by created_at desc', function () {
    $user = User::factory()->create();

    $older = \App\Models\Expense::create([
        'name' => 'Older',
        'amount' => '10.00',
        'active' => true,
    ]);
    $older->timestamps = false;
    $older->created_at = now()->subDay();
    $older->save();

    $newer = \App\Models\Expense::create([
        'name' => 'Newer',
        'amount' => '20.00',
        'active' => true,
    ]);
    $newer->timestamps = false;
    $newer->created_at = now();
    $newer->save();

    $response = $this->actingAs($user)->get(route('expenses.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('expenses/Index')
        ->where('create_url', route('expenses.create', absolute: false))
        ->where('index_url', route('expenses.index', absolute: false))
        ->where('filters.per_page', 15)
        ->where('expenses.data.0.name', 'Newer')
        ->where('expenses.data.0.edit_url', route('expenses.edit', $newer, absolute: false))
        ->where('expenses.data.0.destroy_url', route('expenses.destroy', $newer, absolute: false))
        ->where('expenses.data.1.name', 'Older')
        ->where('page_total_amount', '30.00')
    );
});

test('expenses index supports per_page pagination and includes per_page_options', function () {
    $user = User::factory()->create();

    for ($i = 1; $i <= 16; $i++) {
        \App\Models\Expense::create([
            'name' => 'Expense '.$i,
            'amount' => '1.00',
            'active' => true,
        ]);
    }

    $response = $this->actingAs($user)->get(route('expenses.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('expenses/Index')
        ->where('filters.per_page', 15)
        ->has('expenses.data', 15)
        ->where('expenses.total', 16)
        ->where('per_page_options.0', 15)
        ->where('per_page_options.1', 30)
        ->where('per_page_options.2', 50)
        ->where('per_page_options.3', 100)
        ->where('page_total_amount', '15.00')
    );

    $response2 = $this->actingAs($user)->get(route('expenses.index', ['per_page' => 30]));

    $response2->assertOk();

    $response2->assertInertia(fn (Assert $page) => $page
        ->component('expenses/Index')
        ->where('filters.per_page', 30)
        ->has('expenses.data', 16)
        ->where('page_total_amount', '16.00')
    );
});

test('expenses index can filter by category and payment method and totals reflect filtered page', function () {
    $user = User::factory()->create();

    $categoryA = \App\Models\Category::create(['name' => 'Alpha']);
    $categoryB = \App\Models\Category::create(['name' => 'Beta']);

    $pmA = \App\Models\PaymentMethod::create(['name' => 'Card', 'active' => true]);
    $pmB = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    \App\Models\Expense::create([
        'name' => 'E1',
        'amount' => '10.00',
        'category_id' => $categoryA->id,
        'payment_method_id' => $pmA->id,
        'active' => true,
    ]);

    \App\Models\Expense::create([
        'name' => 'E2',
        'amount' => '20.00',
        'category_id' => $categoryA->id,
        'payment_method_id' => $pmB->id,
        'active' => true,
    ]);

    \App\Models\Expense::create([
        'name' => 'E3',
        'amount' => '30.00',
        'category_id' => $categoryB->id,
        'payment_method_id' => $pmA->id,
        'active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('expenses.index', [
        'category_id' => $categoryA->id,
        'payment_method_id' => $pmA->id,
        'per_page' => 15,
    ]));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('expenses/Index')
        ->where('filters.category_id', $categoryA->id)
        ->where('filters.payment_method_id', $pmA->id)
        ->has('expenses.data', 1)
        ->where('expenses.data.0.name', 'E1')
        ->where('page_total_amount', '10.00')
    );
});
