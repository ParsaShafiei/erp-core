<?php

namespace App\Models;

use App\Models\Product;
use App\Models\DailySalesReport;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class DailySalesReportItem extends Model
{
    //
    public function dailySalesReport(): BelongsTo
    {
        return $this->belongsTo(DailySalesReport::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
