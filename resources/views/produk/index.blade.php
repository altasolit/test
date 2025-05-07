{{-- resources/views/produk/index.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 mt-6 bg-white rounded-xl shadow-m">
        @if (session('success'))
            <div id="success-alert" class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div id="loading-indicator" class="hidden mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-md">
            Menghapus data...
        </div>
        <div class="flex items-center justify-between mb-6">
            <h4 class="text-2xl font-semibold text-gray-800">Daftar Produk</h4>
            <a href="{{ route('produk.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow">
                Tambah Produk
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Nama Produk</th>
                        {{-- <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Harga</th>
                        <th class="px-6 py-3">Stok</th> --}}
                        <th class="px-6 py-3">Gambar</th>
                        {{-- <th class="px-6 py-3">Kategori</th> --}}
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($produk as $no => $produk)
                        <tr>
                            <td class="px-6 py-4">{{ $no + 1 }}</td>
                            <td class="px-6 py-4 font-medium">{{ $produk->nama_produk }}</td>
                            {{-- <td class="px-6 py-4 text-gray-600">{{ $produk->deskripsi }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $produk->stok }}</td> --}}
                            <td class="px-6 py-4">
                                @if ($produk->nama_file)
                                    <img src="{{ asset('img/' . $produk->nama_file) }}" alt="gambar produk"
                                        class="w-16 h-16 object-cover rounded-md border border-gray-300 shadow">
                                @else
                                    <span class="italic text-gray-400">Tidak ada gambar</span>
                                @endif
                            </td>
                            {{-- <td class="px-6 py-4">{{ $produk->kategori->nama_kategori }}</td> --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded-md shadow show-btn"
                                        data-nama="{{ $produk->nama_produk }}" data-deskripsi="{{ $produk->deskripsi }}"
                                        data-harga="{{ number_format($produk->harga, 0, ',', '.') }}"
                                        data-stok="{{ $produk->stok }}"
                                        data-kategori="{{ $produk->kategori->nama_kategori }}"
                                        data-foto="{{ $produk->nama_file ? asset('img/' . $produk->nama_file) : '' }}">
                                        Show
                                    </button>

                                    <a href="{{ route('produk.edit', $produk->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md shadow">
                                        Edit
                                    </a>

                                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                                        data-confirm="Apakah anda yakin ingin menghapus kategori ini?"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="showModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center overflow-y-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg relative transition-all duration-300">
            
            <!-- Tombol Tutup -->
            <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-2xl focus:outline-none">
                &times;
            </button>
    
            <!-- Konten Modal -->
            <div id="modalContent" class="flex flex-col md:flex-row">
                
                <!-- Gambar & Kategori -->
                <div class="relative w-full md:w-1/2">
                    <img id="modalImage" src="" alt="Gambar Produk"
                        class="h-64 md:h-full w-full object-cover rounded-t-xl md:rounded-l-xl md:rounded-tr-none" />
                    <span id="modalKategori"
                        class="absolute top-3 left-3 bg-slate-600 text-white text-xs font-medium px-3 py-1 rounded-full shadow-md">
                    </span>
                </div>
    
                <!-- Detail -->
                <div class="w-full md:w-1/2 p-5 space-y-3">
                    <h2 id="modalNama" class="text-xl font-semibold text-gray-800 leading-snug"></h2>
                    <p id="modalDeskripsi" class="text-sm text-gray-600 leading-relaxed"></p>
    
                    <div class="flex justify-between items-center text-sm text-gray-700 font-medium pt-2 border-t">
                        <p id="modalHarga" class="text-green-600 text-base font-semibold"></p>
                        <p id="modalStok" class="text-sm bg-gray-100 px-2 py-1 rounded-md"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>     

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showButtons = document.querySelectorAll('.show-btn');
                const modal = document.getElementById('showModal');
                const closeModal = document.getElementById('closeModal');

                showButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        document.getElementById('modalNama').textContent = 'Nama Produk: ' + this
                            .getAttribute(
                                'data-nama');
                        document.getElementById('modalDeskripsi').textContent = 'Deskripsi: ' + this
                            .getAttribute(
                                'data-deskripsi');
                        document.getElementById('modalHarga').textContent = 'Rp ' + this.getAttribute(
                            'data-harga');
                        document.getElementById('modalStok').textContent = 'Stok: ' + this.getAttribute(
                            'data-stok');
                        document.getElementById('modalKategori').textContent = this
                            .getAttribute('data-kategori');

                        const foto = this.getAttribute('data-foto');
                        if (foto) {
                            document.getElementById('modalImage').src = foto;
                            document.getElementById('modalImage').classList.remove('hidden');
                        } else {
                            document.getElementById('modalImage').classList.add('hidden');
                        }

                        modal.classList.remove('hidden');
                    });
                });

                closeModal.addEventListener('click', function() {
                    modal.classList.add('hidden');
                });

                window.addEventListener('click', function(e) {
                    if (e.target == modal) {
                        modal.classList.add('hidden');
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForms = document.querySelectorAll('.delete-form');
                const loadingIndicator = document.getElementById('loading-indicator');
                const successAlert = document.getElementById('success-alert');

                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        const confirmMessage = form.getAttribute('data-confirm');
                        if (!confirm(confirmMessage)) {
                            e.preventDefault();
                            return;
                        }

                        loadingIndicator.classList.remove('hidden');
                    });
                });

                if (successAlert) {
                    setTimeout(() => {
                        successAlert.style.display = 'none';
                    }, 3000); // hilang setelah 3 detik
                }
            });
        </script>
    @endpush
</x-app-layout>
