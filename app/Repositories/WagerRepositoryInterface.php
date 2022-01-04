<?php

namespace App\Repositories;

interface WagerRepositoryInterface
{
    public function createWager(array $wager);
    public function listWagers(int $page = 1, int $limit = 10): array;
    public function buyWager(int $id, $buyingPrice): bool;
}