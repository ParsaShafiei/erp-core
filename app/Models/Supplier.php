<?php

namespace App\Models;

use App\Models\SupplierProduct;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    public function products(): HasMany
    {
        return $this->hasMany(SupplierProduct::class, 'supplier_id');
    }
}
