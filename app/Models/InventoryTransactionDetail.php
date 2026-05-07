<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;

class InventoryTransactionDetail extends Model
{
    protected $fillable = [
        'inventory_transaction_id',
        'item_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
