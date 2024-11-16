<?php

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_products(): void
    {
        $user = User::factory()->create();
        $products = Product::factory(100)->create();

        $token = $user->createToken('api')->plainTextToken;

        $response = $this->getJson('/api/product/', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                ]
            ],
        ]);
    }

    public function test_create_order(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $basket = Basket::query()->create(['user_id' => $user->id]);

        $token = $user->createToken('api')->plainTextToken;

        $updateBasket = $this->patchJson('/api/basket/update', [
            'product_id' => $product->id,
            'quantity' => 5
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $updateBasket->assertStatus(200);

        $paymentType = Payment::query()->create(['name' => 'Наличные']);

        $createOrder = $this->postJson('/api/order/create', [
            'basket_id' => $basket->id,
            'payment_type' => $paymentType->id
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);


        $createOrder->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'paymentType' => [
                        'id',
                        'name'
                    ],
                    'products' => [
                        '*' => [
                            'id',
                            'price',
                            'quantity',
                            'sum',
                            'product' => [
                                'id',
                                'name',
                                'description',
                                'price',
                            ]
                        ]
                    ],
                    'paymentLink',
                ],
            ]);
    }
}
