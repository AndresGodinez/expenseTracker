<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Category $category) => [
                'id' => $category->id,
                'name' => $category->name,
                'edit_url' => route('categories.edit', $category, absolute: false),
                'destroy_url' => route('categories.destroy', $category, absolute: false),
            ]);

        return Inertia::render('categories/Index', [
            'categories' => $categories,
            'create_url' => route('categories.create', absolute: false),
        ]);
    }

    public function create()
    {
        return Inertia::render('categories/Create', [
            'store_url' => route('categories.store', absolute: false),
            'index_url' => route('categories.index', absolute: false),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        Category::create($validated);

        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return Inertia::render('categories/Edit', [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'update_url' => route('categories.update', $category, absolute: false),
            ],
            'index_url' => route('categories.index', absolute: false),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
