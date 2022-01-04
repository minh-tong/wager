<?php

namespace App\Repositories;

use App\Models\Wager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WagerRepository extends BaseRepository implements WagerRepositoryInterface
{
    public function getModel()
    {
        return Wager::class;
    }

    /**
     *
     * @param array $wager
     * 
     * @return Wager
     */
    public function createWager($wager): Wager
    {
        $wager['current_selling_price'] = $wager['selling_price'];

        return $this->model::create($wager);
    }

    /**
     *
     * @param array $wager
     * 
     * @return array
     */
    public function listWagers(int $page = 1, int $limit = 10): array
    {
        return $this->model::limit($limit)->offset(($page - 1) * $limit)->latest()->get()->toArray();
    }

    /**
     *
     * @param Wager $wager
     * @param float $buyingPrice
     * 
     * @return boolean
     */
    public function updateWager(Wager $wager, $buyingPrice = 0): bool
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
     * @return boolean
     */
    public function buyWager(int $id, $buyingPrice): bool
    {
        return app('db')->transaction(function () use ($id, $buyingPrice) {
            $wager = $this->model::where('id', $id)->lockForUpdate()->first();

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

            return $this->updateWager($wager, $buyingPrice);
        });
    }
}