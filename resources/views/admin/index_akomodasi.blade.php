<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akomodasi - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/akomodasiadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="akomodasi-container">
            <div class="page-header">
                <div class="page-header-left">
                    <h1 class="page-title">
                        Kelola Akomodasi
                    </h1>
                    <h4 class="page-subtitle">Tambah, edit, atau hapus akomodasi</h4>
                </div>
                <a href="{{ route('admin.akomodasi.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i>
                    Tambah Akomodasi
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="search-container">
                <form action="{{ route('admin.akomodasi.index') }}" method="GET" class="search-form">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Cari akomodasi, nama, atau alamat..."
                        value="{{ $search }}"
                    >
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('admin.akomodasi.index') }}" class="btn-search" style="background: #718096;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="table-container">
                @if($akomodasi->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Akomodasi</th>
                                <th>Alamat</th>
                                <th>Lokasi</th>
                                <th>Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($akomodasi as $index => $item)
                                <tr>
                                    <td>{{ $akomodasi->firstItem() + $index }}</td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>{{ Str::limit($item->alamat, 50) }}</td>
                                    <td>
                                        @if($item->lokasi == 'solo')
                                            <span style="background: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem;">
                                                Solo
                                            </span>
                                        @else
                                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem;">
                                                Yogyakarta
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->rating)
                                            <span style="display: inline-flex; align-items: center; gap: 0.25rem;">
                                                <i class="fas fa-star" style="color: #fbbf24;"></i>
                                                <span>{{ number_format($item->rating, 1) }}</span>
                                            </span>
                                        @else
                                            <span style="color: #718096;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.akomodasi.edit', $item->id) }}" class="btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.akomodasi.destroy', $item->id) }}" method="POST" class="delete-form" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" title="Hapus" onclick="return confirmDelete(event)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination-info">
                        Menampilkan data ke-{{ $akomodasi->firstItem() }} sampai {{ $akomodasi->lastItem() }} 
                        dari {{ $akomodasi->total() }} akomodasi 
                    </div>

                    <div class="pagination-buttons">
                        @if($akomodasi->onFirstPage())
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">← Sebelumnya</span>
                        @else
                            <a href="{{ $akomodasi->previousPageUrl() }}{{ $search ? '&search=' . $search : '' }}" class="btn-pagination">← Sebelumnya</a>
                        @endif

                        @if($akomodasi->hasMorePages())
                            <a href="{{ $akomodasi->nextPageUrl() }}{{ $search ? '&search=' . $search : '' }}" class="btn-pagination">Berikutnya →</a>
                        @else
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">Berikutnya →</span>
                        @endif
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-bed"></i>
                        <h3>Tidak ada data akomodasi</h3>
                        <p>{{ $search ? 'Tidak ditemukan akomodasi yang sesuai dengan pencarian.' : 'Belum ada akomodasi yang ditambahkan.' }}</p>
                        @if(!$search)
                            <a href="{{ route('admin.akomodasi.create') }}" class="btn-add" style="margin-top: 1rem;">
                                <i class="fas fa-plus"></i>
                                Tambah Akomodasi Pertama
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
