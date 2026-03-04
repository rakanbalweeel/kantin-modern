<?php

namespace App\Http\Controllers;

/**
 * ============================================================================
 * CONTROLLER: ProductController
 * ============================================================================
 * 
 * PENJELASAN:
 * Controller untuk CRUD Produk (makanan/minuman) di kantin.
 * Hanya bisa diakses oleh Admin.
 * 
 * FITUR:
 * - CRUD Produk lengkap
 * - Upload gambar produk
 * - Manajemen stok
 * - Filter berdasarkan kategori
 * 
 * RELASI YANG DIGUNAKAN:
 * - Product belongsTo Category (setiap produk punya 1 kategori)
 * - Category hasMany Products (1 kategori punya banyak produk)
 * ============================================================================
 */

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     * GET /admin/products
     * 
     * PENJELASAN:
     * - with('category'): Eager loading untuk menghindari N+1 query
     * - Filter berdasarkan kategori jika ada parameter
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('nama')->paginate(10);
        $categories = Category::orderBy('nama')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     * GET /admin/products/create
     */
    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     * POST /admin/products
     * 
     * PENJELASAN UPLOAD GAMBAR:
     * 1. Cek apakah ada file gambar
     * 2. Jika ada, simpan ke storage/app/public/products
     * 3. Path yang disimpan: products/nama_file.jpg
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified product.
     * GET /admin/products/{product}
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     * GET /admin/products/{product}/edit
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     * PUT /admin/products/{product}
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified product from storage.
     * DELETE /admin/products/{product}
     */
    public function destroy(Product $product)
    {
        // Cek apakah produk pernah dipesan
        if ($product->orderDetails()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah pernah dipesan.');
        }

        // Hapus gambar jika ada
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Update stock (tambah/kurang stok)
     * PUT /admin/products/{product}/stock
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'adjustment' => 'required|integer',
            'type' => 'required|in:add,subtract',
        ]);

        $adjustment = $request->adjustment;

        if ($request->type === 'add') {
            $product->increaseStock($adjustment);
            $message = "Stok berhasil ditambah {$adjustment} unit.";
        } else {
            if (!$product->hasStock($adjustment)) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $product->decreaseStock($adjustment);
            $message = "Stok berhasil dikurangi {$adjustment} unit.";
        }

        return back()->with('success', $message);
    }
}
