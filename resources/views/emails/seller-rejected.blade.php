<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #DC3545; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px; background: #f9f9f9; }
        .reason-box { background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pemberitahuan Status Pendaftaran</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $seller->nama_pic }}</strong>,</p>
            
            <p>Mohon maaf, kami harus memberitahukan bahwa pendaftaran toko Anda 
            <strong>"{{ $seller->nama_toko }}"</strong> <strong>tidak dapat disetujui</strong> saat ini.</p>
            
            <div class="reason-box">
                <strong>Alasan Penolakan:</strong>
                <p>{{ $seller->rejection_reason }}</p>
            </div>
            
            <p>Anda dapat mendaftar kembali setelah memperbaiki hal-hal yang disebutkan di atas.</p>
            
            <p>Jika Anda memiliki pertanyaan, silakan hubungi tim support kami.</p>
            
            <p>Terima kasih atas pengertian Anda.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BeliDongBos Marketplace. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
