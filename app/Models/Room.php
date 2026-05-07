<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'name',
        'code',
        'description',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function inventoryRooms()
    {
        return $this->hasMany(InventoryRoom::class);
    }

    protected static function booted()
    {
        static::creating(function ($room) {
            if (empty($room->code)) {
                $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $room->name), 0, 3));
                $prefix = str_pad($prefix, 3, 'X');

                $lastRoom = self::where('code', 'like', 'ROM-' . $prefix . '-%')
                    ->orderBy('code', 'desc')
                    ->first();

                $nextNumber = $lastRoom
                    ? ((int) substr($lastRoom->code, -3)) + 1
                    : 1;

                $room->code = 'ROM-' . $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
