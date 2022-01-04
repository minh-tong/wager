<?php

namespace App\Http\Controllers;

use App\Repositories\WagerRepositoryInterface;
use App\Rules\WagerPrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WagerController extends Controller
{
    /**
     *
     * @param Request $request
     */
    private function _startValidation(Request $request)
    {
        return $this->validate($request,  [
            'total_wager_value' => 'required|integer|min:0',
            'odds' => 'required|integer|min:0',
            'selling_percentage' => 'required|integer|min:1|max:100',
            'selling_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', new WagerPrice($request)]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/wagers",
     *     tags={"Wager"},
     *     summary="Add new wager",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="selling_price",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="total_wager_value",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="selling_percentage",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="odds",
     *                     type="number"
     *                 ),
     *                 example={"selling_price": 1, "selling_percentage": 1, "total_wager_value": 1, "odds": 1}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *            @OA\Schema(ref="#/components/schemas/Wager"),
     *            @OA\Examples(example="result", value={"id": 1, "selling_price": 1, "selling_percentage": 1, "total_wager_value": 1, "odds": 1, "current_selling_price": 0, "percentage_sold": 100, "amount_sold": 1, "placed_at": "2022-01-05T14:39:05.000000Z"}, summary="An result object.")
     *         )
     *     )
     * )
     * 
     * @param Request $request
     * @param WagerRepositoryInterface $wagerRepository
     * 
     * @return JsonResponse
     */
    public function index(Request $request, WagerRepositoryInterface $wagerRepository)
    {
        $this->_startValidation($request);

        return new JsonResponse(
            $wagerRepository->createWager($request->all()),
            Response::HTTP_CREATED
        );
    }
}