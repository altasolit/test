<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 mt-6 bg-white rounded-xl shadow-md">
        @if (session('success'))
            <div id="success-alert" class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div id="loading-indicator" class="hidden mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-md">
            Menghapus data...
        </div>

        <div class="flex items-center justify-between mb-6">
            <h4 class="text-2xl font-semibold text-gray-800">Daftar Kategori</h4>
            <a href="{{ route('kategori.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow">
                Tambah Kategori
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($kategori as $no => $kategori)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $no + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $kategori->nama_kategori }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <a href="{{ route('kategori.edit', $kategori->id) }}"
                                    class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md shadow">
                                    Edit
                                </a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                    class="inline-block delete-form"
                                    data-confirm="Apakah anda yakin ingin menghapus kategori ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    {{-- @if ($kategori->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-sm text-gray-500 py-6">Belum ada kategori.</td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
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
