<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\Income;
use Inertia\Inertia;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Income $income) => [
                'id' => $income->id,
                'name' => $income->name,
                'edit_url' => route('incomes.edit', $income, absolute: false),
                'destroy_url' => route('incomes.destroy', $income, absolute: false),
            ]);

        return Inertia::render('incomes/Index', [
            'incomes' => $incomes,
            'create_url' => route('incomes.create', absolute: false),
        ]);
    }

    public function create()
    {
        return Inertia::render('incomes/Create', [
            'store_url' => route('incomes.store', absolute: false),
            'index_url' => route('incomes.index', absolute: false),
        ]);
    }

    public function store(StoreIncomeRequest $request)
    {
        Income::create($request->validated());

        return redirect()->route('incomes.index');
    }

    public function edit(Income $income)
    {
        return Inertia::render('incomes/Edit', [
            'income' => [
                'id' => $income->id,
                'name' => $income->name,
                'update_url' => route('incomes.update', $income, absolute: false),
            ],
            'index_url' => route('incomes.index', absolute: false),
        ]);
    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $income->update($request->validated());

        return redirect()->route('incomes.index');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('incomes.index');
    }
}
