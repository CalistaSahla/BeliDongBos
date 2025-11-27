<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(90deg, #663399, #008080); color: white; padding: 20px; text-align: center; border-bottom: 4px solid #FFD700; }
        .content { padding: 30px; background: linear-gradient(135deg, #FFFACD, #E6E6FA); }
        .button { display: inline-block; background: #FF6B35; color: white; padding: 12px 30px; text-decoration: none; border: 3px solid #333; margin: 20px 0; font-weight: bold; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Selamat! Pendaftaran Disetujui</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $seller->nama_pic }}</strong>,</p>
            
            <p>Kami dengan senang hati memberitahukan bahwa pendaftaran toko Anda 
            <strong>"{{ $seller->nama_toko }}"</strong> telah <strong>disetujui</strong>!</p>
            
            <p>Untuk mengaktifkan akun Anda, silakan klik tombol di bawah ini:</p>
            
            <p style="text-align: center;">
                <a href="{{ route('seller.activate', $seller->activation_token) }}" class="button">
                    Aktifkan Akun Saya
                </a>
            </p>
            
            <p>Setelah aktivasi, Anda dapat login dan mulai menambahkan produk ke toko Anda.</p>
            
            <p>Jika tombol tidak berfungsi, salin dan tempel link berikut di browser Anda:</p>
            <p style="word-break: break-all; background: #eee; padding: 10px;">
                {{ route('seller.activate', $seller->activation_token) }}
            </p>
            
            <p>Terima kasih telah bergabung dengan BeliDongBos!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BeliDongBos Marketplace. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
