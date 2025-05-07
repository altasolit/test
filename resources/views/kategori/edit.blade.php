<x-app-layout>
    <div class="max-w-xl mx-auto px-4 py-6">
        <h4 class="text-2xl font-semibold text-gray-800 mb-4">Edit Kategori</h4>

        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ $kategori->nama_kategori }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                @error('nama_kategori')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
