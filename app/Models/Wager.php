<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Wager extends Model
{
    protected $attributes = [
        'percentage_sold' => 0,
        'amount_sold' => 0
    ];

    public $fillable = [
        'total_wager_value',
        'odds',
        'selling_percentage',
        'selling_price',
        'current_selling_price',
    ];

    const CREATED_AT = 'placed_at';
    const UPDATED_AT = 'placed_at';

    /**
     * One to many relationship with Purcharse
     */
    public function purchases()
    {
        return $this->hasMany(Purcharse::class);
    }
}