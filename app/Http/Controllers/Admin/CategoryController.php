<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $rootCategories = Category::query()
            ->roots()
            ->withCount('products')
            ->with([
                'children' => fn ($query) => $query->withCount('products'),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('rootCategories'));
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category(),
            'parentOptions' => Category::query()->roots()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($this->validatedPayload($request));

        return redirect()->route('admin.categories.index')->with('success', __('ui.flash.category_created'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category->load('parent', 'children'),
            'parentOptions' => Category::query()
                ->roots()
                ->whereKeyNot($category->id)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(StoreCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($this->validatedPayload($request, $category));

        return redirect()->route('admin.categories.index')->with('success', __('ui.flash.category_updated'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->children()->exists()) {
            return back()->with('error', __('ui.flash.category_children_first'));
        }

        if ($category->products()->exists()) {
            return back()->with('error', __('ui.flash.category_products_first'));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', __('ui.flash.category_deleted'));
    }

    private function validatedPayload(StoreCategoryRequest $request, ?Category $category = null): array
    {
        $validated = $request->validated();
        $parentId = $validated['parent_id'] ?? null;

        if ($parentId !== null) {
            $parent = Category::query()->findOrFail($parentId);

            if (! $parent->isRoot()) {
                throw ValidationException::withMessages([
                    'parent_id' => __('ui.flash.parent_top_level_only'),
                ]);
            }

            if ($category && $parent->is($category)) {
                throw ValidationException::withMessages([
                    'parent_id' => __('ui.flash.category_cannot_parent_self'),
                ]);
            }

            if ($category && $category->children()->exists()) {
                throw ValidationException::withMessages([
                    'parent_id' => __('ui.flash.category_with_children_cannot_be_child'),
                ]);
            }
        }

        if (! $category?->exists) {
            $validated['slug'] = $this->uniqueSlug($validated['name']);
        }

        $validated['name_ar'] = $validated['name_ar'] ?? null;
        $validated['description_ar'] = $validated['description_ar'] ?? null;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['parent_id'] = $parentId;
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    private function uniqueSlug(string $name, ?Category $category = null): string
    {
        $base = Str::slug($name) ?: 'category';
        $slug = $base;
        $counter = 2;

        while (
            Category::query()
                ->where('slug', $slug)
                ->when($category, fn ($query) => $query->whereKeyNot($category->id))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
