<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profiledetailakun.css') }}">
    <!-- Bootstrap causes conflicts with the custom navbar components, so we rely solely on custom CSS -->
</head>
<body>
    @if(auth()->user()->role === 'wisatawan')
        @include('layout.wisatawannavbar')
    @else
        @include('layout.adminnavbar')
    @endif

    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <i class="fas fa-user-circle"></i>
                <h2>Detail Akun</h2>
                <p>Informasi profil Anda di sistem Itinerary Wisata.</p>
            </div>

            <table class="profile-details-table">
                <tbody>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td>{{ $user->no_telp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Peran Akses</th>
                        <td><span class="badge-role">{{ str_replace('_', ' ', $user->role) }}</span></td>
                    </tr>
                    <tr>
                        <th>Tanggal Bergabung</th>
                        <td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="text-center mt-4" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 15px;">
                <button type="button" class="btn-warning" onclick="openPasswordModal()">
                    <i class="fas fa-key"></i> Ubah Password
                </button>
                @if(auth()->user()->role === 'wisatawan')
                    <a href="{{ route('wisatawan.dashboard') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div id="passwordModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" onclick="closePasswordModal()">&times;</span>
            <div class="modal-header">
                <h3>Ubah Password</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.password.update') }}" method="POST" id="passwordForm">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <div style="position: relative;">
                            <input type="password" name="current_password" id="current_password" class="form-control" required style="padding-right: 2.5rem;">
                            <i class="fa-regular fa-eye toggle-password" onclick="togglePasswordVisibility('current_password', this)" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b;"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <div style="position: relative;">
                            <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6" style="padding-right: 2.5rem;">
                            <i class="fa-regular fa-eye toggle-password" onclick="togglePasswordVisibility('new_password', this)" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b;"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <div style="position: relative;">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required minlength="6" style="padding-right: 2.5rem;">
                            <i class="fa-regular fa-eye toggle-password" onclick="togglePasswordVisibility('new_password_confirmation', this)" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b;"></i>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closePasswordModal()">Batal</button>
                        <button type="submit" class="btn-save">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Flash Data for Javascript (Mencegah IDE Error) -->
    <div id="flash-data" 
         data-success="{{ session('success') ?? '' }}" 
         data-error="{{ session('error') ?? '' }}" 
         data-validation="{{ json_encode($errors->all() ?? []) }}" 
         style="display: none;"></div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openPasswordModal() {
            var modal = document.getElementById('passwordModal');
            if (modal) modal.classList.add('active');
        }

        function closePasswordModal() {
            var modal = document.getElementById('passwordModal');
            if (modal) modal.classList.remove('active');
            var form = document.getElementById('passwordForm');
            if (form) form.reset();
            
            // Reset icons and types to password
            ['current_password', 'new_password', 'new_password_confirmation'].forEach(function(id) {
                var input = document.getElementById(id);
                if (input) {
                    input.type = 'password';
                    var icon = input.nextElementSibling;
                    if (icon) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                }
            });
        }

        function togglePasswordVisibility(inputId, iconElement) {
            var input = document.getElementById(inputId);
            if (input && input.type === 'password') {
                input.type = 'text';
                iconElement.classList.remove('fa-eye');
                iconElement.classList.add('fa-eye-slash');
            } else if (input) {
                input.type = 'password';
                iconElement.classList.remove('fa-eye-slash');
                iconElement.classList.add('fa-eye');
            }
        }

        // Close modal when clicking outside
        var pwdModal = document.getElementById('passwordModal');
        if (pwdModal) {
            pwdModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closePasswordModal();
                }
            });
        }

        // Notifications
        var flashElement = document.getElementById('flash-data');
        if (flashElement) {
            var successMessage = flashElement.getAttribute('data-success');
            var errorMessage = flashElement.getAttribute('data-error');
            var validationRaw = flashElement.getAttribute('data-validation');
            var validationErrors = [];
            
            if (validationRaw) {
                try {
                    // HTML unescapes &quot; back to quotes so JSON.parse receives valid JSON
                    validationErrors = JSON.parse(validationRaw);
                } catch(e) {
                    console.error("Gagal memparsing JSON validasi", e);
                }
            }

            if (successMessage && successMessage !== '') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successMessage,
                    confirmButtonColor: '#14b8a6'
                });
            }

            if (errorMessage && errorMessage !== '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage,
                    confirmButtonColor: '#ef4444'
                }).then(function() {
                    openPasswordModal();
                });
            }

            if (validationErrors && validationErrors.length > 0) {
                var errorHtml = validationErrors.join('<br>');
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: errorHtml,
                    confirmButtonColor: '#ef4444'
                }).then(function() {
                    openPasswordModal();
                });
            }
        }
    </script>
</body>
</html>
