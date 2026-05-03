<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Status Permohonan Akun</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .footer { margin-top: 30px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Halo, {{ $nama }}!</h2>
        <p>Terima kasih atas ketertarikan Anda untuk mendaftar pada Sistem Itinerary Wisata kami.</p>
        <p>Setelah melakukan peninjauan terhadap permohonan akun Anda, kami memohon maaf karena saat ini permohonan Anda <strong>belum dapat disetujui (ditolak)</strong>.</p>
        <p>Anda dapat mencoba mengajukan permohonan akun kembali di lain waktu dengan melengkapi informasi yang dibutuhkan melalui form permohonan kami.</p>
        <br>
        <p>Terima kasih atas pengertian Anda,<br>Tim Sistem Itinerary</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Sistem Itinerary. Semua Hak Cipta Dilindungi.
    </div>
</body>
</html>
