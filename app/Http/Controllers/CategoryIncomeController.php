<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryIncomeRequest;
use App\Http\Requests\UpdateCategoryIncomeRequest;
use App\Models\CategoryIncome;
use Inertia\Inertia;

class CategoryIncomeController extends Controller
{
    public function index()
    {
        $categoryIncomes = CategoryIncome::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (CategoryIncome $categoryIncome) => [
                'id' => $categoryIncome->id,
                'name' => $categoryIncome->name,
                'edit_url' => route('category-incomes.edit', $categoryIncome, absolute: false),
                'destroy_url' => route('category-incomes.destroy', $categoryIncome, absolute: false),
            ]);

        return Inertia::render('category-incomes/Index', [
            'category_incomes' => $categoryIncomes,
            'create_url' => route('category-incomes.create', absolute: false),
        ]);
    }

    public function create()
    {
        return Inertia::render('category-incomes/Create', [
            'store_url' => route('category-incomes.store', absolute: false),
            'index_url' => route('category-incomes.index', absolute: false),
        ]);
    }

    public function store(StoreCategoryIncomeRequest $request)
    {
        CategoryIncome::create($request->validated());

        return redirect()->route('category-incomes.index');
    }

    public function edit(CategoryIncome $category_income)
    {
        return Inertia::render('category-incomes/Edit', [
            'category_income' => [
                'id' => $category_income->id,
                'name' => $category_income->name,
                'update_url' => route('category-incomes.update', $category_income, absolute: false),
            ],
            'index_url' => route('category-incomes.index', absolute: false),
        ]);
    }

    public function update(UpdateCategoryIncomeRequest $request, CategoryIncome $category_income)
    {
        $category_income->update($request->validated());

        return redirect()->route('category-incomes.index');
    }

    public function destroy(CategoryIncome $category_income)
    {
        $category_income->delete();

        return redirect()->route('category-incomes.index');
    }
}
