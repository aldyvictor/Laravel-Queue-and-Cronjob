<?php

namespace Tests\Feature;

use App\Models\Transaction;
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
        ]))->assertCreated();

    }
}
