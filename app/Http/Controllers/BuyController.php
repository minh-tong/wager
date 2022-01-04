<?php

namespace App\Http\Controllers;

use App\Repositories\PurchaseRepositoryInterface;
use App\Repositories\WagerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BuyController extends Controller
{
    /**
     *
     * @param Request $request
     */
    private function _startValidation(Request $request)
    {
        return $this->validate($request, [
            'buying_price' => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/buy/{id}",
     *     tags={"Wager"},
     *     summary="Buy a wager",
     *     @OA\Parameter(
     *         description="Wager id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="buying_price",
     *                     type="number"
     *                 ),
     *                 example={"buying_price": 1}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent(
     *            @OA\Schema(ref="#/components/schemas/Purchase"),
     *            @OA\Examples(example="result", value={"id": 1, "buying_price": 1, "wager_id": 1, "bought_at": "2022-01-05T14:39:05.000000Z"}, summary="An result object.")
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @param WagerRepositoryInterface $wagerRepository
     * @param PurchaseRepositoryInterface $purchaseRepository
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function index(
        Request $request,
        WagerRepositoryInterface $wagerRepository,
        PurchaseRepositoryInterface $purchaseRepository,
        int $id
    ): JsonResponse {
        $this->_startValidation($request);

        /**
         * Instead of using Route Model Binding in this case
         * I lock the column to prevent the duplicate update 
         * if there is the multiple requests at the same time
         */
        $wagerRepository->buyWager($id, $request->get('buying_price'));

        return new JsonResponse($purchaseRepository->getTheLatestPurchase($id), Response::HTTP_CREATED);
    }
}