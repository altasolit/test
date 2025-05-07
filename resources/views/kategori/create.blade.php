<x-app-layout>
    <div class="max-w-xl mx-auto px-4 py-8">
        <h4 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kategori</h4>

        <form action="{{ route('kategori.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-sm space-y-5">
            @csrf

            <div>
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input 
                    type="text" 
                    name="nama_kategori" 
                    id="nama_kategori" 
                    value="{{ old('nama_kategori') }}"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400"
                    required
                >
                @error('nama_kategori')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <button type="submit" class="bg-green-600 hover:bg-green-700 transition duration-150 text-white font-semibold px-5 py-2 rounded-lg shadow">
                    Tambah
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
