<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['uuid', 'code', 'name', 'address', 'manager_id', 'is_active'])]
class Warehouse extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function inventoryLocation(): MorphOne
    {
        return $this->morphOne(InventoryLocation::class, 'locatable');
    }

    public function userAssignments(): HasMany
    {
        return $this->hasMany(UserWarehouseAssignment::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_warehouse_assignments')
            ->withPivot(['is_primary'])
            ->withTimestamps();
    }
}
