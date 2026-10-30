<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class DailySalesReport extends Model
{
    //
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
