<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // <--- Penting untuk UUID
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    // Relasi ke User (Milik siapa alamat ini)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
