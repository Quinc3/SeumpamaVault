<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryRoom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inventory_id',
        'room_id',
        'quantity',
        'status',
        'assigned_at',
        'description',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
