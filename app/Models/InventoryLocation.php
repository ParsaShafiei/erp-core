<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['locatable_type', 'locatable_id', 'code', 'name', 'type', 'is_active'])]
class InventoryLocation extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function locatable(): MorphTo
    {
        return $this->morphTo();
    }

    public function locationStock(): HasMany
    {
        return $this->hasMany(LocationStock::class, 'location_id');
    }

    public function outgoingTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'from_location_id');
    }

    public function incomingTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'to_location_id');
    }

    public function stockAdjustments(): HasMany
    {
        return $this->hasMany(StockAdjustment::class, 'location_id');
    }

    public function productionOrders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class, 'location_id');
    }

    public function salesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'location_id');
    }

    public function transfersFrom(): HasMany
    {
        return $this->hasMany(Transfer::class, 'from_location_id');
    }

    public function transfersTo(): HasMany
    {
        return $this->hasMany(Transfer::class, 'to_location_id');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'location_id');
    }
}
