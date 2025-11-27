<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = [
        'product_id',
        'nama',
        'nomor_hp',
        'email',
        'rating',
        'komentar',
        'province_id',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    protected static function booted()
    {
        static::created(function ($rating) {
            $rating->product->updateRatingStats();
        });

        static::deleted(function ($rating) {
            $rating->product->updateRatingStats();
        });
    }
}
