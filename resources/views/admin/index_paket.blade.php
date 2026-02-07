<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket Wisata - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paketadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="paket-container">
            <div class="page-header">
                <div class="page-header-left">
                    <h1 class="page-title">
                        Kelola Paket Wisata
                    </h1>
                    <h4 class="page-subtitle">Tambah, edit, atau hapus paket wisata</h4>
                </div>
                <a href="{{ route('admin.paket.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i>
                    Tambah Paket
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="search-container">
                <form action="{{ route('admin.paket.index') }}" method="GET" class="search-form">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Cari paket wisata..."
                        value="{{ $search }}"
                    >
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('admin.paket.index') }}" class="btn-search" style="background: #718096;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="table-container">
                @if($paket->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Paket</th>
                                <th>Gambar</th>
                                <th>Durasi</th>
                                <th>Destinasi</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paket as $index => $item)
                                <tr>
                                    <td>{{ $paket->firstItem() + $index }}</td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->nama }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <span style="color: #718096;">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->durasi }} hari</td>
                                    <td>
                                        @if($item->destinasi->count() > 0)
                                            <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                                <!-- <i class="fas fa-map-marked-alt" style="color: #667eea;"></i> -->
                                                <span style="color: #718096;">{{ $item->destinasi->count() }}</span>
                                                <span style="color: #718096; font-size: 0.875rem;">destinasi</span>
                                            </span>
                                        @else
                                            <span style="color: #718096;">-</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.paket.edit', $item->id) }}" class="btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.paket.destroy', $item->id) }}" method="POST" class="delete-form" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" title="Hapus" onclick="return confirmDelete(event)">
                                                    <i class="fas fa-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination-info">
                        Menampilkan data ke-{{ $paket->firstItem() }} sampai {{ $paket->lastItem() }} 
                        dari {{ $paket->total() }} paket wisata 
                    </div>

                    <div class="pagination-buttons">
                        @if($paket->onFirstPage())
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">← Sebelumnya</span>
                        @else
                            <a href="{{ $paket->previousPageUrl() }}{{ $search ? '&search=' . $search : '' }}" class="btn-pagination">← Sebelumnya</a>
                        @endif

                        @if($paket->hasMorePages())
                            <a href="{{ $paket->nextPageUrl() }}{{ $search ? '&search=' . $search : '' }}" class="btn-pagination">Berikutnya →</a>
                        @else
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">Berikutnya →</span>
                        @endif
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-box"></i>
                        <h3>Tidak ada data paket wisata</h3>
                        <p>{{ $search ? 'Tidak ditemukan paket wisata yang sesuai dengan pencarian.' : 'Belum ada paket wisata yang ditambahkan.' }}</p>
                        @if(!$search)
                            <a href="{{ route('admin.paket.create') }}" class="btn-add" style="margin-top: 1rem;">
                                <i class="fas fa-plus"></i>
                                Tambah Paket Wisata
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
