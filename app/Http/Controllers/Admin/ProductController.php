<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));

        $products = Product::query()
            ->with('category.parent')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($innerQuery) use ($search): void {
                    $innerQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->simplePaginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product(),
            'categoryOptions' => $this->categoryOptions(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($this->validatedPayload($request));

        return redirect()->route('admin.products.index')->with('success', __('ui.flash.product_created'));
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product->load('category.parent'),
            'categoryOptions' => $this->categoryOptions(),
        ]);
    }

    public function update(StoreProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($this->validatedPayload($request, $product));

        return redirect()->route('admin.products.index')->with('success', __('ui.flash.product_updated'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteStoredImage($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('ui.flash.product_deleted'));
    }

    private function validatedPayload(StoreProductRequest $request, ?Product $product = null): array
    {
        $validated = $request->validated();
        $selectedCategory = Category::query()->withCount('children')->findOrFail($validated['category_id']);

        if ($selectedCategory->children_count > 0) {
            throw ValidationException::withMessages([
                'category_id' => __('ui.flash.products_must_use_child_category'),
            ]);
        }

        $validated['slug'] = $this->uniqueSlug($validated['name'], $product);
        $validated['featured'] = $request->boolean('featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['quantity'] = (int) $validated['quantity'];

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeUploadedImage($request->file('image'));

            if ($product) {
                $this->deleteStoredImage($product->image);
            }
        } elseif ($product) {
            $validated['image'] = $product->image;
        }

        return $validated;
    }

    private function categoryOptions(): Collection
    {
        return Category::query()
            ->with('parent')
            ->withCount('children')
            ->orderByRaw('case when parent_id is null then 0 else 1 end')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    private function uniqueSlug(string $name, ?Product $product = null): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $counter = 2;

        while (
            Product::query()
                ->where('slug', $slug)
                ->when($product, fn ($query) => $query->whereKeyNot($product->id))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function storeUploadedImage(UploadedFile $image): string
    {
        $directory = public_path('uploads/products');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = Str::uuid()->toString().'.'.$image->getClientOriginalExtension();
        $image->move($directory, $filename);

        return 'uploads/products/'.$filename;
    }

    private function deleteStoredImage(?string $imagePath): void
    {
        if (! $imagePath || str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return;
        }

        $fullPath = public_path($imagePath);

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
