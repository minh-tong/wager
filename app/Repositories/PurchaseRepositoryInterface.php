<?php

namespace App\Repositories;

use App\Models\Purcharse;

interface PurchaseRepositoryInterface
{
    /**
     *
     * @param int $wagerId
     * 
     * @return Purcharse
     */
    public function getTheLatestPurchase(int $wagerId): Purcharse;
}
