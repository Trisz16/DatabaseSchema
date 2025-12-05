<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    // Relasi ke Induk (Parent)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relasi ke Anak (Sub-categories)
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relasi ke Produk
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
