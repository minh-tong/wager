<?php

class WagerTest extends TestCase
{
    /**
     * This init should be place in data seeder ot factory
     * and for saving time I put it to technical dept for refactoring later
     * but hopefullly I won't back to this src after pass the coding interview haha
     */
    protected function _createWager()
    {
        return $this->call('POST', '/wagers', [
            "selling_price" =>  1,
            "total_wager_value"  => 1,
            "selling_percentage" =>  1,
            "odds" => 69
        ]);
    }

    /**
     * Create wager testing
     *
     * @return void
     */
    public function testCouldNotCreateWagerWithInvalidData()
    {
        $response = $this->call('POST', '/wagers');

        $response
            ->assertStatus(422)
            ->assertJson([
                "total_wager_value" =>  [
                    "The total wager value field is required."
                ],
                "odds" => [
                    "The odds field is required."
                ],
                "selling_percentage" => [
                    "The selling percentage field is required."
                ],
                "selling_price" => [
                    "The selling price field is required."
                ]
            ]);
    }

    /**
     * Create wager testing
     *
     * @return void
     */
    public function testCanCreateAWagerData()
    {
        $this->_createWager()->assertStatus(201);
    }


    /**
     * Buy wager testing
     *
     * @return void
     */
    public function testCouldNotBuyAWagerData()
    {
        $response = $this->call('POST', '/buy/1', []);

        $response
            ->assertStatus(422)
            ->assertJson([
                'buying_price' => ['The buying price field is required.']
            ]);
    }

    /**
     * Buy wager testing
     *
     * @return void
     */
    public function testBuyingPriceShouldBeaPositiveNumber()
    {
        $response = $this->call('POST', '/buy/1', ['buying_price' => -1]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'buying_price' => ['The buying price format is invalid.']
            ]);
    }

    /**
     * Buy wager testing
     *
     * @return void
     */
    public function testCouldNotBuyNonExistingWagerData()
    {
        $response = $this->call('POST', '/buy/99999', ['buying_price' => 1]);

        $response
            ->assertStatus(404)
            ->assertJson([
                'error' => 'Record not found',
            ]);
    }

    /**
     * Buy wager testing
     * 
     * @return void
     */
    public function testCanBuyAWagerData()
    {
        $this->_createWager();
        $wagers = $this->get('/wagers')->seeStatusCode(200)->response->getContent();
        $id = json_decode($wagers, true)[0]['id'];

        $response = $this->call('POST', "/buy/{$id}", ['buying_price' => 1]);

        $response->assertStatus(201);
		
		$response = $this->call('POST', "/buy/{$id}", ['buying_price' => 1]);
        $response
            ->assertStatus(500)
            ->assertJson([
                'error' => 'The wager was sold out',
            ]);
    }

    /**
     * Buy wager testing
     * 
     * @return void
     */
    public function testCanGetListOfWagers()
    {
        $this->_createWager();
        $response = $this->call('GET', '/wagers');
        $response
            ->assertStatus(200)
            ->assertJsonCount(1);
    }
}