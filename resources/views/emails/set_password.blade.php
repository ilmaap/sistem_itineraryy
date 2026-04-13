<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Atur Password Anda</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 12px 24px; background-color: #4CAF50; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold; margin-top: 20px; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Halo, {{ $nama }}!</h2>
        <p>Kabar gembira! Permohonan akun atau pendaftaran Anda pada Sistem Itinerary telah disetujui oleh Admin kami.</p>
        <p>Agar Anda dapat segera login dan menggunakan layanan kami, silakan atur dan buat password Anda sendiri dengan mengeklik tombol di bawah ini:</p>
        
        <center>
            <a href="{{ $url }}" class="btn" style="color:white;">Atur Password Saya</a>
        </center>
        
        <p>Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan tautan berikut ini ke browser Anda:</p>
        <p style="word-break: break-all; color: #0056b3;">{{ $url }}</p>
        
        <p>Tautan ini bersifat rahasia dan berlaku sementara. Segera lakukan pengaturan password untuk keamanan akun Anda.</p>
        
        <p>Terima kasih,<br>Tim Sistem Itinerary</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Sistem Itinerary. Semua Hak Cipta Dilindungi.
    </div>
</body>
</html>
