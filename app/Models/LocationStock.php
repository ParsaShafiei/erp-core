<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'location_id',
    'product_id',
    'quantity_on_hand',
    'quantity_reserved',
    'reorder_level',
])]
class LocationStock extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'quantity_on_hand' => 'decimal:3',
            'quantity_reserved' => 'decimal:3',
            'reorder_level' => 'integer',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(InventoryLocation::class, 'location_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
