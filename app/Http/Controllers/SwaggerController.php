<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * This controller do nothing
 * It just renders swagger info
 */
class SwaggerController extends BaseController
{
    /**
     * @license Apache 2.0
     */

    /**
     * @OA\Info(
     *     description="This is Swagger APi for Wager module",
     *     version="1.0.0",
     *     title="Wager",
     *     termsOfService="http://swagger.io/terms/",
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *  schema="Wager",
     * 	@OA\Property(
     * 		property="id",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="total_wager_value",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="odds",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="selling_percentage",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="selling_price",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="current_selling_price",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="percentage_sold",
     * 		type="number"
     *  ),
     * 	@OA\Property(
     * 		property="amount_sold",
     * 		type="number"
     *  ),
     * 	@OA\Property(
     * 		property="placed_at",
     * 		type="date"
     * 	)
     * )
     */

    /**
     * @OA\Schema(
     *  schema="Purchase",
     * 	@OA\Property(
     * 		property="id",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="buying_price",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="wager_id",
     * 		type="number"
     * 	),
     * 	@OA\Property(
     * 		property="bought_at",
     * 		type="date"
     * 	),
     * )
     */
}