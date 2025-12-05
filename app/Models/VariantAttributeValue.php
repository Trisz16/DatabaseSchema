<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot; // Use Pivot instead of Model
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class VariantAttributeValue extends Pivot
{
    use HasUuids; // Auto-generate UUID for 'id'

    protected $table = 'variant_attribute_values';
    public $incrementing = false;
    protected $guarded = ['id'];
}
