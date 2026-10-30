<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_active
 * @property Carbon|null $last_login_at
 * @property string|null $last_login_ip
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable([
    'uuid',
    'name',
    'email',
    'phone',
    'password',
    'is_active',
    'two_factor_secret',
    'two_factor_recovery_codes',
    'last_login_at',
    'last_login_ip',
    'email_verified_at',
])]
#[Hidden(['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, HasUuid, Notifiable, SoftDeletes;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
            'two_factor_secret' => 'encrypted',
            'two_factor_recovery_codes' => 'encrypted',
        ];
    }

    public function branchAssignments(): HasMany
    {
        return $this->hasMany(UserBranchAssignment::class);
    }

    public function warehouseAssignments(): HasMany
    {
        return $this->hasMany(UserWarehouseAssignment::class);
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'user_branch_assignments')
            ->withPivot(['is_primary'])
            ->withTimestamps();
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'user_warehouse_assignments')
            ->withPivot(['is_primary'])
            ->withTimestamps();
    }

    public function managedWarehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class, 'manager_id');
    }

    public function managedBranches(): HasMany
    {
        return $this->hasMany(Branch::class, 'manager_id');
    }

    public function managedRepresentatives(): HasMany
    {
        return $this->hasMany(Representative::class, 'assigned_manager_id');
    }

    public function createdRepresentatives(): HasMany
    {
        return $this->hasMany(Representative::class, 'created_by');
    }

    public function productPriceChanges(): HasMany
    {
        return $this->hasMany(ProductPriceHistory::class, 'changed_by');
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'performed_by');
    }

    public function requestedStockAdjustments(): HasMany
    {
        return $this->hasMany(StockAdjustment::class, 'requested_by');
    }

    public function approvedStockAdjustments(): HasMany
    {
        return $this->hasMany(StockAdjustment::class, 'approved_by');
    }

    public function createdBoms(): HasMany
    {
        return $this->hasMany(Bom::class, 'created_by');
    }

    public function createdProductionOrders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class, 'created_by');
    }

    public function approvedProductionOrders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class, 'approved_by');
    }

    public function createdSalesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'created_by');
    }

    public function approvedSalesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'approved_by');
    }

    public function receivedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'received_by');
    }

    public function requestedTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'requested_by');
    }

    public function approvedTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'approved_by');
    }

    public function shippedTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'shipped_by');
    }

    public function receivedTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'received_by');
    }

    public function createdPurchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'created_by');
    }

    public function approvedPurchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'approved_by');
    }

    public function goodsReceipts(): HasMany
    {
        return $this->hasMany(GoodsReceipt::class, 'received_by');
    }

    public function ledgerEntries(): HasMany
    {
        return $this->hasMany(LedgerEntry::class, 'created_by');
    }

    public function submittedDailySalesReports(): HasMany
    {
        return $this->hasMany(DailySalesReport::class, 'submitted_by');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
