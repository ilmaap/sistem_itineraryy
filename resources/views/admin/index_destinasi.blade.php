<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Destinasi - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/destinasiadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="destinasi-container">
            <div class="page-header">
                <div class="page-header-left">
                    <h1 class="page-title">
                        Kelola Destinasi
                    </h1>
                    <h4 class="page-subtitle">Tambah, edit, atau hapus destinasi wisata</h4>
                </div>
                <a href="{{ route('admin.destinasi.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i>
                    Tambah Destinasi
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="search-container">
                <form action="{{ route('admin.destinasi.index') }}" method="GET" class="search-form">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Cari destinasi, kategori, atau alamat..."
                        value="{{ $search }}"
                    >
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('admin.destinasi.index') }}" class="btn-search" style="background: #718096;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="table-container">
                @if($destinasi->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Destinasi</th>
                                <th>Kategori</th>
                                <th>Alamat</th>
                                <th>Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($destinasi as $index => $item)
                                <tr>
                                    <td>{{ $destinasi->firstItem() + $index }}</td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>
                                        <span style="background: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem;">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>
                                        @if($item->rating)
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <span>{{ number_format($item->rating, 1) }}</span>
                                            </div>
                                        @else
                                            <span style="color: #cbd5e0;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.destinasi.edit', $item->id) }}" class="btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.destinasi.destroy', $item->id) }}" method="POST" class="delete-form" style="display: inline;">
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
                        Menampilkan data ke-{{ $destinasi->firstItem() }} sampai {{ $destinasi->lastItem() }} 
                        dari {{ $destinasi->total() }} destinasi
                    </div>

                    <div class="pagination-buttons">
                        @if($destinasi->onFirstPage())
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">← Sebelumnya</span>
                        @else
                            <a href="{{ $destinasi->previousPageUrl() }}{{ $search ? '&search=' . $search : '' }}" class="btn-pagination">← Sebelumnya</a>
                        @endif

                        @if($destinasi->hasMorePages())
                            <a href="{{ $destinasi->nextPageUrl() }}{{ $search ? '&search=' . $search : '' }}" class="btn-pagination">Berikutnya →</a>
                        @else
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">Berikutnya →</span>
                        @endif
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-map-marked-alt"></i>
                        <h3>Tidak ada data destinasi</h3>
                        <p>{{ $search ? 'Tidak ditemukan destinasi yang sesuai dengan pencarian.' : 'Belum ada destinasi yang ditambahkan.' }}</p>
                        @if(!$search)
                            <a href="{{ route('admin.destinasi.create') }}" class="btn-add" style="margin-top: 1rem;">
                                <i class="fas fa-plus"></i>
                                Tambah Destinasi Pertama
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
