<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 15);
        $perPage = in_array($perPage, [15, 30, 50, 100], true) ? $perPage : 15;

        $expenses = Expense::query()
            ->with(['category:id,name', 'paymentMethod:id,name'])
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->integer('category_id')))
            ->when($request->filled('payment_method_id'), fn ($q) => $q->where('payment_method_id', $request->integer('payment_method_id')))
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn (Expense $expense) => [
                'id' => $expense->id,
                'name' => $expense->name,
                'amount' => (string) $expense->amount,
                'active' => $expense->active,
                'created_at' => optional($expense->created_at)->toISOString(),
                'category' => $expense->category ? ['id' => $expense->category->id, 'name' => $expense->category->name] : null,
                'payment_method' => $expense->paymentMethod ? ['id' => $expense->paymentMethod->id, 'name' => $expense->paymentMethod->name] : null,
                'edit_url' => route('expenses.edit', $expense, absolute: false),
                'destroy_url' => route('expenses.destroy', $expense, absolute: false),
            ]);

        $pageTotal = $expenses->getCollection()->sum(fn (array $row) => (float) $row['amount']);

        $categories = Category::query()->orderBy('name')->get(['id', 'name']);
        $paymentMethods = PaymentMethod::query()->orderBy('name')->get(['id', 'name']);

        $pageTotalAmount = number_format($pageTotal, 2, '.', '');

        return Inertia::render('expenses/Index', [
            'expenses' => $expenses,
            'create_url' => route('expenses.create', absolute: false),
            'index_url' => route('expenses.index', absolute: false),
            'filters' => [
                'category_id' => $request->filled('category_id') ? $request->integer('category_id') : null,
                'payment_method_id' => $request->filled('payment_method_id') ? $request->integer('payment_method_id') : null,
                'per_page' => $perPage,
            ],
            'categories' => $categories,
            'payment_methods' => $paymentMethods,
            'per_page_options' => [15, 30, 50, 100],
            'page_total_amount' => $pageTotalAmount,
        ]);
    }

    public function create()
    {
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);
        $paymentMethods = PaymentMethod::query()->orderBy('name')->get(['id', 'name']);

        return Inertia::render('expenses/Create', [
            'store_url' => route('expenses.store', absolute: false),
            'index_url' => route('expenses.index', absolute: false),
            'categories' => $categories,
            'payment_methods' => $paymentMethods,
        ]);
    }

    public function store(StoreExpenseRequest $request)
    {
        $validated = $request->validated();

        if (! array_key_exists('active', $validated)) {
            $validated['active'] = true;
        }

        Expense::create($validated);

        return redirect()->route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        $expense->load(['category:id,name', 'paymentMethod:id,name']);

        $categories = Category::query()->orderBy('name')->get(['id', 'name']);
        $paymentMethods = PaymentMethod::query()->orderBy('name')->get(['id', 'name']);

        return Inertia::render('expenses/Edit', [
            'expense' => [
                'id' => $expense->id,
                'name' => $expense->name,
                'amount' => (string) $expense->amount,
                'category_id' => $expense->category_id,
                'payment_method_id' => $expense->payment_method_id,
                'active' => $expense->active,
                'update_url' => route('expenses.update', $expense, absolute: false),
            ],
            'index_url' => route('expenses.index', absolute: false),
            'categories' => $categories,
            'payment_methods' => $paymentMethods,
        ]);
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $validated = $request->validated();

        $expense->update([
            'name' => $validated['name'],
            'amount' => $validated['amount'],
            'category_id' => $validated['category_id'] ?? null,
            'payment_method_id' => $validated['payment_method_id'] ?? null,
            'active' => $validated['active'] ?? $expense->active,
        ]);

        return redirect()->route('expenses.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index');
    }
}
