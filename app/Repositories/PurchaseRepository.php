<?php

namespace App\Repositories;

use App\Models\Purcharse;

class PurchaseRepository extends BaseRepository implements PurchaseRepositoryInterface
{
    public function getModel()
    {
        return Purcharse::class;
    }

    /**
     *
     * @param int $wagerId
     * 
     * @return Purcharse
     */
    public function getTheLatestPurchase(int $wagerId): Purcharse
    {
        return $this->model::where('wager_id', $wagerId)->latest()->first();
    }
}