<?php

namespace App\Http\Controllers;

use App\Models\Purcharse;
use App\Models\Wager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class BuyController extends BaseController
{
    /**
     *
     * @param Request $request
     */
    private function _startValidation(Request $request)
    {
        return $this->validate($request, [
            'buying_price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
        ]);
    }

    /**
     *
     * @param Request $request
     * @param int $id
     */
    public function index(Request $request, int $id)
    {
        $this->_startValidation($request);

        /**
         * Instead of using Route Model Binding in this case
         * I lock the column to prevent the duplicate update 
         * in the multiple request at the same time
         */
        Wager::buyWager($id, $request->get('buying_price'));

        return new JsonResponse(Purcharse::getTheLasestPurchase($id), Response::HTTP_CREATED);
    }
}