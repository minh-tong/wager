<?php

namespace App\Http\Controllers;

use App\Repositories\WagerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WagerListController extends Controller
{
    /**
     * @return int
     */
    protected function getLimit(): int
    {
        return env('LIMIT');
    }

    /**
     * To prevent the heavily load 
     * it needs to prevent the big number from $limit
     * 
     * @return int
     */
    protected function getListMaximumLimit(int $limit): int
    {
        $maxLimit = env('MAX_LIMIT');

        if ($limit > $maxLimit || 0 >= $limit) {
            return $maxLimit;
        }

        return $limit;
    }

    /**
     * @OA\Get(
     *     path="/wagers",
     *     tags={"Wager"},
     *     summary="Get wagers list",
     *     operationId="wagers",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Page limit",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Wager")
     *         )
     *     ),
     * )
     * 
     * @param Request $request
     * @param WagerRepositoryInterface $wagerRepository
     * 
     * @return JsonResponse
     */
    public function index(Request $request, WagerRepositoryInterface $wagerRepository): JsonResponse
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? $this->getLimit();

        return new JsonResponse(
            $wagerRepository->listWagers($page, $this->getListMaximumLimit($limit))
        );
    }
}