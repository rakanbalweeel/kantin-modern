<?php

namespace App\Http\Controllers;

/**
 * ============================================================================
 * CONTROLLER: CategoryController
 * ============================================================================
 * 
 * PENJELASAN:
 * Controller untuk CRUD Kategori produk (hanya untuk Admin).
 * Menggunakan Route Resource sehingga otomatis memiliki 7 method standar.
 * 
 * ROUTE RESOURCE METHODS:
 * | Method | URI                    | Action  | Deskripsi           |
 * |--------|------------------------|---------|---------------------|
 * | GET    | /categories            | index   | List semua kategori |
 * | GET    | /categories/create     | create  | Form tambah         |
 * | POST   | /categories            | store   | Simpan baru         |
 * | GET    | /categories/{id}       | show    | Detail kategori     |
 * | GET    | /categories/{id}/edit  | edit    | Form edit           |
 * | PUT    | /categories/{id}       | update  | Update data         |
 * | DELETE | /categories/{id}       | destroy | Hapus data          |
 * ============================================================================
 */

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     * GET /admin/categories
     */
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('nama')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     * GET /admin/categories/create
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     * POST /admin/categories
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified category.
     * GET /admin/categories/{category}
     */
    public function show(Category $category)
    {
        $category->load('products');
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     * GET /admin/categories/{category}/edit
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     * PUT /admin/categories/{category}
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified category from storage.
     * DELETE /admin/categories/{category}
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
