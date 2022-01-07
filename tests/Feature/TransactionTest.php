<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_new_transaction()
    {
        $response = $this->post(route('transaction.checkout', [
            'user_id' => 1,
            'product_id' => 1,
            'product_qty' => 20,
            'product_image_name' => 'null',
            'product_image_url' => 'null',
            'expired_at' => '2022-01-23 08:23:23',
            'amount' => 200000
        ]))->assertOk();

    }

    public function test_get_user_history()
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'tomat',
            'price' => 10000,
            'product_image_original_name' => 'null',
            'product_image_original_url' => 'null',
            'product_image_large_name' => 'null',
            'product_image_large_url' => 'null',
            'product_image_medium_name' => 'null',
            'product_image_medium_url' => 'null',
            'product_image_small_name' => 'null',
            'product_image_small_url' => 'null',
        ]);
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_qty' => 20,
            'product_image_name' => 'null',
            'product_image_url' => 'null',
            'expired_at' => '2022-01-23 08:23:23',
            'amount' => 200000
        ]);
        $response  = $this->actingAs($user)->get('api/transaction-history/'. $user->id)
                        ->assertOk();

        $this->assertEquals($transaction->user_id, $user->id);
    }
}
