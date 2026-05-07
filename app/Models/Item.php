<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item_type_id',
        'code',
        'name',
        'unit',
        'description',
    ];

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    protected static function booted()
    {
        static::creating(function ($item) {

            if (empty($item->code)) {

                // ambil prefix dari nama
                $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $item->name), 0, 3));
                $prefix = str_pad($prefix, 3, 'X');

                // ambil nomor terakhir
                $lastItem = self::where('code', 'like', 'ITM-' . $prefix . '-%')
                    ->orderBy('code', 'desc')
                    ->first();

                if ($lastItem) {
                    $lastNumber = (int) substr($lastItem->code, -3);
                    $nextNumber = $lastNumber + 1;
                } else {
                    $nextNumber = 1;
                }

                $item->code = 'ITM-' . $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
