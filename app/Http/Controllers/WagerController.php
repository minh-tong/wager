<?php

namespace App\Http\Controllers;

use App\Models\Wager;
use App\Rules\WagerPrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class WagerController extends BaseController
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
            'selling_percentage' => 'required|integer|min:0|max:100',
            'selling_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', new WagerPrice($request)]
        ]);
    }

    /**
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $this->_startValidation($request);

        return new JsonResponse(
            Wager::createWager($request->all()),
            Response::HTTP_CREATED
        );
    }
}