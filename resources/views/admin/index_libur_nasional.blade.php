<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Hari Libur - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/liburnasionaladmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="libur-nasional-container">
            <div class="page-header">
                <div class="page-header-left">
                    <h1 class="page-title">
                        Kelola Hari Libur
                    </h1>
                    <h4 class="page-subtitle">Tambah, edit, atau hapus hari libur nasional</h4>
                </div>
                <a href="{{ route('admin.libur_nasional.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i>
                    Tambah Hari Libur
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
                <form action="{{ route('admin.libur_nasional.index') }}" method="GET" class="search-form">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Cari hari libur, nama, atau tahun..."
                        value="{{ $search }}"
                    >
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('admin.libur_nasional.index') }}" class="btn-search" style="background: #718096;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="table-container">
                @if($liburNasional->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Tahun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($liburNasional as $index => $item)
                                <tr>
                                    <td>{{ $liburNasional->firstItem() + $index }}</td>
                                    <td><strong>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</strong></td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.libur_nasional.edit', $item->id) }}" class="btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.libur_nasional.destroy', $item->id) }}" method="POST" class="delete-form" style="display: inline;">
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
                        Menampilkan data ke-{{ $liburNasional->firstItem() }} sampai {{ $liburNasional->lastItem() }} 
                        dari {{ $liburNasional->total() }} hari libur 
                    </div>

                    <div class="pagination-buttons">
                        @if($liburNasional->onFirstPage())
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">← Sebelumnya</span>
                        @else
                            <a href="{{ $liburNasional->previousPageUrl() }}{{ $search ? '&search=' . $search : '' }}" class="btn-pagination">← Sebelumnya</a>
                        @endif

                        @if($liburNasional->hasMorePages())
                            <a href="{{ $liburNasional->nextPageUrl() }}{{ $search ? '&search=' . $search : '' }}" class="btn-pagination">Berikutnya →</a>
                        @else
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">Berikutnya →</span>
                        @endif
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h3>Tidak ada data hari libur</h3>
                        <p>{{ $search ? 'Tidak ditemukan hari libur yang sesuai dengan pencarian.' : 'Belum ada hari libur yang ditambahkan.' }}</p>
                        @if(!$search)
                            <a href="{{ route('admin.libur_nasional.create') }}" class="btn-add" style="margin-top: 1rem;">
                                <i class="fas fa-plus"></i>
                                Tambah Hari Libur Pertama
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

