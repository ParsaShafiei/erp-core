<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
    'uuid',
    'product_id',
    'bom_id',
    'location_id',
    'planned_quantity',
    'produced_quantity',
    'status',
    'planned_date',
    'started_at',
    'completed_at',
    'created_by',
    'approved_by',
])]
class ProductionOrder extends Model
{
    use HasFactory, HasUuid;

    protected function casts(): array
    {
        return [
            'planned_quantity' => 'decimal:3',
            'produced_quantity' => 'decimal:3',
            'planned_date' => 'date',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function bom(): BelongsTo
    {
        return $this->belongsTo(Bom::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(InventoryLocation::class, 'location_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function materials(): HasMany
    {
        return $this->hasMany(ProductionOrderMaterial::class);
    }

    public function inventoryTransactions(): MorphMany
    {
        return $this->morphMany(InventoryTransaction::class, 'reference');
    }
}
