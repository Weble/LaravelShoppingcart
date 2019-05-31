<?php

namespace Gloudemans\Tests\Shoppingcart;

use Orchestra\Testbench\TestCase;
use Weble\LaravelShoppingCart\CartItem;
use Weble\LaravelShoppingCart\ShoppingCartServiceProvider;

class CartItemTest extends TestCase
{
    /**
     * Set the package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ShoppingCartServiceProvider::class];
    }

    /** @test */
    public function it_can_be_cast_to_an_array()
    {
        $cartItem = new CartItem(1, 'Some item', money(10.0), ['size' => 'XL', 'color' => 'red']);
        $cartItem->setQuantity(2);

        $this->assertEquals([
            'id' => 1,
            'name' => 'Some item',
            'price' => money(10)->toArray(),
            'rowId' => '07d5da5550494c62daf9993cf954303f',
            'qty' => 2,
            'options' => [
                'size' => 'XL',
                'color' => 'red'
            ],
            'tax' => money(0)->toArray(),
            'subtotal' => money(20.00)->toArray(),
        ], $cartItem->toArray());
    }

    /** @test */
    public function it_can_be_cast_to_json()
    {
        $cartItem = new CartItem(1, 'Some item', money(10.00), ['size' => 'XL', 'color' => 'red']);
        $cartItem->setQuantity(2);

        $this->assertJson($cartItem->toJson());

        $json = json_encode($cartItem->toArray());

        $this->assertEquals($json, $cartItem->toJson());
    }
}