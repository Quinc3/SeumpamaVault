<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item_id',
        'quantity',
        'price',
        'barcode',
        'expired_date',
        'status',
        'photo',
        'description',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function inventoryRooms()
    {
        return $this->hasMany(InventoryRoom::class);
    }
}
