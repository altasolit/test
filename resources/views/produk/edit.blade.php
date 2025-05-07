<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 mt-6 rounded-xl shadow-md">
        <h4 class="text-2xl font-semibold text-gray-800 mb-6">Edit Produk</h4>

        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('nama_produk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ $produk->deskripsi }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" name="harga" value="{{ $produk->harga }}" min="0" step="0.01"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('harga')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                <input type="number" name="stok" value="{{ $produk->stok }}" min="0"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('stok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" {{ $produk->kategori_id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Baru (Opsional)</label>
                <input type="file" name="nama_file" accept="image/*"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('nama_file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @if ($produk->nama_file)
                    <p class="mt-2 text-sm text-gray-600">Gambar Saat Ini:</p>
                    <img src="{{ asset('img/' . $produk->nama_file) }}" alt="gambar produk"
                        class="w-24 h-auto mt-1 rounded-md shadow border">
                @endif
            </div>

            <div class="col-span-2 text-right">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
