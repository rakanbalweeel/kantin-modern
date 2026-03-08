{{--
==========================================================================
FORM TAMBAH PRODUK (CREATE)
==========================================================================
Halaman ini berisi form untuk menambah produk baru.
Form akan dikirim ke ProductController@store via POST dengan enctype multipart 
karena ada upload gambar.

PENJELASAN FORM
---------------
- enctype="multipart/form-data": Wajib untuk upload file
- $categories: Daftar kategori untuk pilihan select dropdown
- Kode produk: Auto-generate atau manual
- Gambar: Optional, akan di-resize/validate di controller
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button + Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" 
               class="group inline-flex items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-md border border-gray-100 mr-3 group-hover:shadow-lg group-hover:border-indigo-200 group-hover:-translate-x-1 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
                <span class="font-medium">Kembali</span>
            </a>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">Tambah Produk Baru</h1>
            <p class="mt-1 text-gray-600">Tambahkan menu makanan atau minuman baru</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            {{--
            enctype="multipart/form-data"
            --------------------------------
            Atribut ini WAJIB ada jika form memiliki input type="file".
            Tanpa enctype ini, file tidak akan ter-upload ke server.
            --}}
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Kode Produk --}}
                <div class="mb-6">
                    <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Produk <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="kode" 
                        id="kode"
                        value="{{ old('kode') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kode') border-red-500 @enderror"
                        placeholder="Contoh: MKN001, MNM001"
                        required
                    >
                    @error('kode')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Kode unik untuk identifikasi produk.</p>
                </div>

                {{-- Nama Produk --}}
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama" 
                        id="nama"
                        value="{{ old('nama') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama') border-red-500 @enderror"
                        placeholder="Contoh: Mie Ayam Special"
                        required
                    >
                    @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="mb-6">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="category_id" 
                        id="category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-6">
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="harga" 
                        id="harga"
                        value="{{ old('harga') }}"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('harga') border-red-500 @enderror"
                        placeholder="Contoh: 15000"
                        required
                    >
                    @error('harga')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="mb-6">
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Awal <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="stok" 
                        id="stok"
                        value="{{ old('stok', 0) }}"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('stok') border-red-500 @enderror"
                        placeholder="Contoh: 50"
                        required
                    >
                    @error('stok')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea 
                        name="deskripsi" 
                        id="deskripsi"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi') border-red-500 @enderror"
                        placeholder="Deskripsi produk (opsional)"
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Gambar dengan Preview --}}
                <div class="mb-6" x-data="imageUpload()">
                    <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Produk
                    </label>
                    
                    {{-- Preview Container --}}
                    <div x-show="imagePreview" class="mb-4 relative inline-block">
                        <img :src="imagePreview" class="w-40 h-40 object-cover rounded-xl shadow-lg border-4 border-white">
                        <button type="button" 
                                @click="removeImage()" 
                                class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-200 hover:scale-110">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <div class="mt-2 text-sm text-gray-600" x-text="fileName"></div>
                    </div>

                    {{-- Upload Area --}}
                    <div x-show="!imagePreview"
                         class="relative mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 bg-gray-50 hover:bg-indigo-50/30 transition-all duration-300 cursor-pointer"
                         :class="{ 'border-indigo-500 bg-indigo-50': isDragging }"
                         @dragover.prevent="isDragging = true"
                         @dragleave.prevent="isDragging = false"
                         @drop.prevent="handleDrop($event)"
                         @click="$refs.fileInput.click()">
                        <div class="space-y-3 text-center">
                            <div class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-semibold text-indigo-600">Klik untuk upload</span>
                                <span> atau drag & drop gambar</span>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, WEBP • Maksimal 2MB</p>
                        </div>
                        <input x-ref="fileInput" 
                               id="gambar" 
                               name="gambar" 
                               type="file" 
                               class="hidden" 
                               accept="image/jpeg,image/png,image/webp"
                               @change="handleFileSelect($event)">
                    </div>
                    @error('gambar')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function imageUpload() {
    return {
        imagePreview: null,
        fileName: '',
        isDragging: false,
        
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) this.previewFile(file);
        },
        
        handleDrop(event) {
            this.isDragging = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.$refs.fileInput.files = event.dataTransfer.files;
                this.previewFile(file);
            }
        },
        
        previewFile(file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                return;
            }
            this.fileName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => { this.imagePreview = e.target.result; };
            reader.readAsDataURL(file);
        },
        
        removeImage() {
            this.imagePreview = null;
            this.fileName = '';
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endpush
