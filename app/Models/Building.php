<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    protected static function booted()
    {
        static::creating(function ($building) {
            if (empty($building->code)) {
                $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $building->name), 0, 3));
                $prefix = str_pad($prefix, 3, 'X');

                $lastBuilding = self::where('code', 'like', 'BLD-' . $prefix . '-%')
                    ->orderBy('code', 'desc')
                    ->first();

                $nextNumber = $lastBuilding
                    ? ((int) substr($lastBuilding->code, -3)) + 1
                    : 1;

                $building->code = 'BLD-' . $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
