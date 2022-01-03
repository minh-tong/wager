<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purcharse extends Model
{
    public $fillable = [
        "wager_id",
        "buying_price",
    ];

    const CREATED_AT = 'bought_at';
    const UPDATED_AT = 'bought_at';

    public static function getTheLasestPurchase(int $wagerId)
    {
        return self::where('wager_id', $wagerId)->latest()->first();
    }
}