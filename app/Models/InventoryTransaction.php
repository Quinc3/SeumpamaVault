<?php

namespace App\Models;

use App\Models\InventoryTransactionDetail;
use App\Models\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_type_id',
        'transaction_code',
        'transaction_date',
        'total_budget',
        'total_realization',
        'evidence_file',
        'description',
    ];

    public function details()
    {
        return $this->hasMany(InventoryTransactionDetail::class);
    }

    public function type()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }
}
