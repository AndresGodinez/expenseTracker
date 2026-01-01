<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Account $account) => [
                'id' => $account->id,
                'name' => $account->name,
                'edit_url' => route('accounts.edit', $account, absolute: false),
                'destroy_url' => route('accounts.destroy', $account, absolute: false),
            ]);

        return Inertia::render('accounts/Index', [
            'accounts' => $accounts,
            'create_url' => route('accounts.create', absolute: false),
        ]);
    }

    public function create()
    {
        return Inertia::render('accounts/Create', [
            'store_url' => route('accounts.store', absolute: false),
            'index_url' => route('accounts.index', absolute: false),
        ]);
    }

    public function store(StoreAccountRequest $request)
    {
        Account::create($request->validated());

        return redirect()->route('accounts.index');
    }

    public function edit(Account $account)
    {
        return Inertia::render('accounts/Edit', [
            'account' => [
                'id' => $account->id,
                'name' => $account->name,
                'update_url' => route('accounts.update', $account, absolute: false),
            ],
            'index_url' => route('accounts.index', absolute: false),
        ]);
    }

    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->update($request->validated());

        return redirect()->route('accounts.index');
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()->route('accounts.index');
    }
}
