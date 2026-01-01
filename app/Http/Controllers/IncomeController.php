<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\Account;
use App\Models\CategoryIncome;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Inertia\Inertia;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 15);
        $perPage = in_array($perPage, [15, 30, 50, 100], true) ? $perPage : 15;

        $incomes = Income::query()
            ->with(['categoryIncome:id,name', 'account:id,name'])
            ->when($request->filled('category_income_id'), fn ($q) => $q->where('category_income_id', $request->integer('category_income_id')))
            ->when($request->filled('account_id'), fn ($q) => $q->where('account_id', $request->integer('account_id')))
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn (Income $income) => [
                'id' => $income->id,
                'name' => $income->name,
                'amount' => (string) $income->amount,
                'created_at' => optional($income->created_at)->toISOString(),
                'category_income' => $income->categoryIncome ? ['id' => $income->categoryIncome->id, 'name' => $income->categoryIncome->name] : null,
                'account' => $income->account ? ['id' => $income->account->id, 'name' => $income->account->name] : null,
                'edit_url' => route('incomes.edit', $income, absolute: false),
                'destroy_url' => route('incomes.destroy', $income, absolute: false),
            ]);

        $pageTotal = $incomes->getCollection()->sum(fn (array $row) => (float) $row['amount']);
        $pageTotalAmount = '$'.str_replace(',', ' ', Number::format($pageTotal, 2));

        $categoryIncomes = CategoryIncome::query()->orderBy('name')->get(['id', 'name']);
        $accounts = Account::query()->orderBy('name')->get(['id', 'name']);

        return Inertia::render('incomes/Index', [
            'incomes' => $incomes,
            'create_url' => route('incomes.create', absolute: false),
            'index_url' => route('incomes.index', absolute: false),
            'filters' => [
                'category_income_id' => $request->filled('category_income_id') ? $request->integer('category_income_id') : null,
                'account_id' => $request->filled('account_id') ? $request->integer('account_id') : null,
                'per_page' => $perPage,
            ],
            'category_incomes' => $categoryIncomes,
            'accounts' => $accounts,
            'per_page_options' => [15, 30, 50, 100],
            'page_total_amount' => $pageTotalAmount,
        ]);
    }

    public function create()
    {
        $categoryIncomes = CategoryIncome::query()->orderBy('name')->get(['id', 'name']);
        $accounts = Account::query()->orderBy('name')->get(['id', 'name']);

        return Inertia::render('incomes/Create', [
            'store_url' => route('incomes.store', absolute: false),
            'index_url' => route('incomes.index', absolute: false),
            'category_incomes' => $categoryIncomes,
            'accounts' => $accounts,
        ]);
    }

    public function store(StoreIncomeRequest $request)
    {
        Income::create($request->validated());

        return redirect()->route('incomes.index');
    }

    public function edit(Income $income)
    {
        $income->load(['categoryIncome:id,name', 'account:id,name']);

        $categoryIncomes = CategoryIncome::query()->orderBy('name')->get(['id', 'name']);
        $accounts = Account::query()->orderBy('name')->get(['id', 'name']);

        return Inertia::render('incomes/Edit', [
            'income' => [
                'id' => $income->id,
                'name' => $income->name,
                'amount' => (string) $income->amount,
                'category_income_id' => $income->category_income_id,
                'account_id' => $income->account_id,
                'update_url' => route('incomes.update', $income, absolute: false),
            ],
            'index_url' => route('incomes.index', absolute: false),
            'category_incomes' => $categoryIncomes,
            'accounts' => $accounts,
        ]);
    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $validated = $request->validated();

        $income->update([
            'name' => $validated['name'],
            'category_income_id' => $validated['category_income_id'],
            'amount' => $validated['amount'],
            'account_id' => $validated['account_id'],
        ]);

        return redirect()->route('incomes.index');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('incomes.index');
    }
}
