<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class WagerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Create wager testing
     *
     * @return void
    
    public function testCouldNotCreateWagerWithInvalidData()
    {
        $response = $this->call('POST', '/wagers');

        $response
            ->assertStatus(422)
            ->assertJson([
                'error' => 'The given data was invalid.',
                'selling_price' => 'selling_price is required'
            ]);
    }
     */

    /**
     * Create wager testing
     *
     * @return void
     */
    public function testCanCreateAWagerData()
    {
        $response = $this->call('POST', '/wagers', [
            "selling_price" =>  1,
            "total_wager_value"  => 1,
            "selling_percentage" =>  1,
            "odds" => 69
        ]);

        $response->assertStatus(201);
    }


    /**
     * Buy wager testing
     *
     * @return void

    public function testCouldNotBuyAWagerData()
    {
        $response = $this->call('POST', '/buy/1', []);

        $response
            ->assertStatus(422)
            ->assertJson([
                'error' => 'The given data was invalid.',
                'buying_price' => 'buying_price is required'
            ]);
    }
     */
    /**
     * Buy wager testing
     *
     * @return void
    
    public function testCouldNotBuyNonExistingWagerData()
    {
        $response = $this->call('POST', '/buy/99999', []);

        $response
            ->assertStatus(404)
            ->assertJson([
                'error' => 'Record not found',
            ]);
    }
     */
    /**
     * Buy wager testing
     * @depends testCanCreateAWagerData
     * @return void
    
    public function testCanBuyAWagerData()
    {
        $response = $this->call('POST', '/buy/1', []);

        $response->assertStatus(201);
    }
     */
    /**
     * Buy wager testing
     * @depends testCanBuyAWagerData
     * @return void
    
    public function testCannotBuyAWagerDataThatWasSoled()
    {
        $response = $this->call('POST', '/buy/1', []);

        $response
            ->assertStatus(500)
            ->assertJson([
                'error' => 'The wager was sold out',
            ]);
    }
     */
}