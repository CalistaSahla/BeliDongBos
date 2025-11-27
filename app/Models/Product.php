<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'category_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'berat',
        'kondisi',
        'min_pembelian',
        'etalase',
        'foto_utama',
        'foto_galeri',
        'is_active',
        'rating_avg',
        'rating_count',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'rating_avg' => 'decimal:2',
        'is_active' => 'boolean',
        'foto_galeri' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->nama_produk) . '-' . Str::random(5);
            }
        });
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNeedsRestock($query)
    {
        return $query->where('stok', '<', 2);
    }

    public function updateRatingStats(): void
    {
        $stats = $this->ratings()->selectRaw('AVG(rating) as avg, COUNT(*) as count')->first();
        $this->update([
            'rating_avg' => $stats->avg ?? 0,
            'rating_count' => $stats->count ?? 0,
        ]);
    }

    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
