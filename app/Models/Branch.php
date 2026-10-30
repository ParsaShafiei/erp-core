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

#[Fillable(['uuid', 'code', 'name', 'address', 'phone', 'manager_id', 'status'])]
class Branch extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

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
        return $this->hasMany(UserBranchAssignment::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_branch_assignments')
            ->withPivot(['is_primary'])
            ->withTimestamps();
    }

    public function dailySalesReports(): HasMany
    {
        return $this->hasMany(DailySalesReport::class);
    }
}
