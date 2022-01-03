<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class WagerPrice implements Rule
{

    private Request $request;

    /**
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $requestAttributes = $this->request->all();

        if (
            !isset($requestAttributes["selling_percentage"]) ||
            !isset($requestAttributes["total_wager_value"])
        ) {
            return false;
        }

        return $value > $requestAttributes["total_wager_value"] * ($requestAttributes["selling_percentage"] / 100);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // Message should be in the translation and time is limited so 
        // i put this improvement in technical-dept
        return 'The selling_price must be greater than total_wager_value * (selling_percentage / 100)';
    }
}