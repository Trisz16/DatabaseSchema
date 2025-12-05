<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasUuids;
    protected $guarded = ['id'];

    // Relasi: Satu atribut punya banyak nilai (Color -> Red, Blue, Green)
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
