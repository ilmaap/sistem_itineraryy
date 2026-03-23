<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Permohonan Akun - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/useradmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="user-container">
            <div class="page-header">
                <div class="page-header-left">
                    <h1 class="page-title">
                        Kelola Permohonan Akun
                    </h1>
                    <h4 class="page-subtitle">Setujui atau tolak permohonan. Riwayat juga ditampilkan.</h4>
                </div>
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
                <form action="{{ route('admin.permohonan.index') }}" method="GET" class="search-form">
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari nama, email, atau nomor telepon..."
                        value="{{ $search }}"
                    >
                    <select
                        name="status"
                        class="search-input"
                        style="max-width: 220px;"
                    >
                        <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="menunggu" {{ ($status ?? '') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ ($status ?? '') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ ($status ?? '') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('admin.permohonan.index') }}" class="btn-search" style="background: #718096;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                    @if(!$search && ($status ?? 'all') !== 'all')
                        <a href="{{ route('admin.permohonan.index') }}" class="btn-search" style="background: #718096;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="table-container">
                @if($permohonan->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Pengajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permohonan as $index => $item)
                                <tr>
                                    <td>{{ $permohonan->firstItem() + $index }}</td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->no_telp }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $statusValue = $item->status;
                                        @endphp
                                        @if($statusValue === 'disetujui')
                                            <span style="background:#d1fae5;color:#065f46;padding:0.25rem 0.75rem;border-radius:12px;font-size:0.875rem;font-weight:600;">Disetujui</span>
                                        @elseif($statusValue === 'ditolak')
                                            <span style="background:#fee2e2;color:#991b1b;padding:0.25rem 0.75rem;border-radius:12px;font-size:0.875rem;font-weight:600;">Ditolak</span>
                                        @else
                                            <span style="background:#fef3c7;color:#92400e;padding:0.25rem 0.75rem;border-radius:12px;font-size:0.875rem;font-weight:600;">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status === 'menunggu')
                                            <div class="action-buttons" style="flex-direction: column; align-items: flex-start;">
                                                <form
                                                    action="{{ route('admin.permohonan.approve', $item->id) }}"
                                                    method="POST"
                                                    style="display: flex; flex-direction: column; gap: 0.5rem;"
                                                    onsubmit="return confirm('Setujui permohonan ini dan buat akun wisatawan?')"
                                                >
                                                    @csrf
                                                    <input
                                                        type="password"
                                                        name="password"
                                                        class="search-input"
                                                        style="width: 100%;"
                                                        placeholder="Password (min 6)"
                                                        minlength="6"
                                                        required
                                                    >
                                                    <input
                                                        type="password"
                                                        name="password_confirmation"
                                                        class="search-input"
                                                        style="width: 100%;"
                                                        placeholder="Konfirmasi password"
                                                        minlength="6"
                                                        required
                                                    >
                                                    <button type="submit" class="btn-add">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>

                                                <form
                                                    action="{{ route('admin.permohonan.reject', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Tolak permohonan ini?')"
                                                >
                                                    @csrf
                                                    <button type="submit" class="btn-delete">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span style="color:#718096; font-size:0.9rem; font-weight:600;">
                                                Sudah diproses
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination-info">
                        Menampilkan data ke-{{ $permohonan->firstItem() }} sampai {{ $permohonan->lastItem() }}
                        dari {{ $permohonan->total() }} permohonan
                    </div>

                    <div class="pagination-buttons">
                        @if($permohonan->onFirstPage())
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">← Sebelumnya</span>
                        @else
                            <a href="{{ $permohonan->previousPageUrl() }}{{ $search ? '&search=' . $search : '' }}{{ ($status ?? 'all') !== 'all' ? '&status=' . $status : '' }}" class="btn-pagination">← Sebelumnya</a>
                        @endif

                        @if($permohonan->hasMorePages())
                            <a href="{{ $permohonan->nextPageUrl() }}{{ $search ? '&search=' . $search : '' }}{{ ($status ?? 'all') !== 'all' ? '&status=' . $status : '' }}" class="btn-pagination">Berikutnya →</a>
                        @else
                            <span class="btn-pagination" style="opacity: 0.5; cursor: not-allowed;">Berikutnya →</span>
                        @endif
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-envelope-open-text"></i>
                        <h3>Tidak ada permohonan</h3>
                        <p>
                            {{ $search ? 'Tidak ditemukan permohonan yang sesuai dengan pencarian.' : 'Belum ada data untuk filter yang dipilih.' }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>


