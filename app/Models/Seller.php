<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends Model
{
    protected $fillable = [
        'user_id',
        'nama_toko',
        'deskripsi_singkat',
        'nama_pic',
        'kontak_pic',
        'alamat_toko',
        'rt',
        'rw',
        'village_id',
        'city_id',
        'province_id',
        'nomor_hp',
        'email',
        'no_ktp',
        'foto_pic',
        'foto_ktp',
        'status',
        'rejection_reason',
        'activation_token',
        'verified_at',
        'is_active',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function getTotalProductsAttribute(): int
    {
        return $this->products()->count();
    }

    public function getTotalStockAttribute(): int
    {
        return $this->products()->sum('stok');
    }
}
