<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(90deg, #663399, #008080); color: white; padding: 20px; text-align: center; border-bottom: 4px solid #FFD700; }
        .content { padding: 30px; background: linear-gradient(135deg, #FFFACD, #E6E6FA); }
        .rating-box { background: white; border: 1px solid #ddd; padding: 20px; border-radius: 5px; margin: 20px 0; }
        .stars { color: #ffc107; font-size: 24px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Terima Kasih atas Ulasan Anda!</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $rating->nama }}</strong>,</p>
            
            <p>Terima kasih telah memberikan ulasan untuk produk di BeliDongBos!</p>
            
            <div class="rating-box">
                <p><strong>Produk:</strong> {{ $product->nama_produk }}</p>
                <p><strong>Rating Anda:</strong></p>
                <p class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $rating->rating)
                            &#9733;
                        @else
                            &#9734;
                        @endif
                    @endfor
                </p>
                <p><strong>Komentar:</strong></p>
                <p>"{{ $rating->komentar }}"</p>
            </div>
            
            <p>Ulasan Anda sangat berarti bagi kami dan membantu penjual serta pembeli lainnya.</p>
            
            <p>Terus berbelanja di BeliDongBos untuk pengalaman belanja online terbaik!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BeliDongBos Marketplace. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
