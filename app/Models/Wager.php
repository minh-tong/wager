<?php

namespace App\Models;

use Exception;
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

    /**
     *
     * @param array $wager
     */
    public static function createWager($wager)
    {
        $wager['current_selling_price'] = $wager['selling_price'];

        return self::create($wager);
    }

    /**
     *
     * @param self $wager
     * @param float $buyingPrice
     */
    public static function updateWager($wager, $buyingPrice = 0)
    {
        // Update the current selling price
        $wager->current_selling_price = $wager->current_selling_price - $buyingPrice;
        $amountSold = $wager->selling_price - $wager->current_selling_price;

        // Update the amount sold
        $wager->amount_sold = $amountSold;

        // Update the proportion of sold
        $wager->percentage_sold = ($amountSold / $wager->selling_price) * 100;

        // Create a purchase
        $wager->purchases()->create(['wager_id' => $wager->id, 'buying_price' => $buyingPrice]);

        return $wager->update();
    }

    /**
     * @param int $id
     * @param mixed $buyingPrice 
     * 
     * return Wager
     */
    public static function buyWager(int $id, $buyingPrice)
    {
        return app('db')->transaction(function () use ($id, $buyingPrice) {
            $wager = self::where('id', $id)->lockForUpdate()->first();


            if (empty($wager)) {
                throw new HttpException(Response::HTTP_NOT_FOUND, "Record not found");
            }

            if ((float) 0 === $wager->current_selling_price) {
                throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, 'The wager was sold out');
            }

            if ($buyingPrice > $wager->current_selling_price) {
                throw new HttpException(
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    "The buying_price should not be higher than {$wager->current_selling_price}",
                );
            }

            return self::updateWager($wager, $buyingPrice);
        });
    }
}