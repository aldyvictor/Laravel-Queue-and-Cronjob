<?php

namespace App\Http\Controllers;

use App\Jobs\UpdatePendingToNoPaid;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $message = [
            'user_id.required' => 'Kolom User ID harus di isi !',
            'user_id.numeric' => 'Kolom User ID harus Angka !',
            'product_id.required' => 'Kolom Produk ID harus di isi !',
            'product_id.numeric' => 'Kolom Produk ID harus Angka !',
            'product_qty.required' => 'Kolom Product Kuantiti harus di isi !',
            'product_qty.numeric' => 'Kolom Product Kuantiti harus Angka !'
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'product_qty' => 'required|numeric'
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ]);
        } else {
            try {
                $product = Product::where('id', $request->product_id)->first();
                $dateNow = Carbon::create(now());
                $dateExpired = $dateNow->addHour(1)->format("Y-m-d H:i:s");
                $amount = $request->product_qty * $product->price;
                // $user = Transaction::with('user')->first();

                $transaction = Transaction::create([
                    'user_id' => $request->user_id,
                    'product_id' => $request->product_id,
                    'product_qty' => $request->product_qty,
                    'product_image_name' => 'null',
                    'product_image_url' => 'null',
                    'expired_at' => $dateExpired,
                    'amount' => $amount
                ]);

                // $details = array (
                //     'email' => $user->user->email,
                //     'name' => $user->user->name,
                //     'subject' => 'Transaction Expired',
                //     'Content' => 'Your transaction alredy expired, please reorder again'
                // );

                MailController::expiredDate($request->user_id);
                dispatch(new UpdatePendingToNoPaid($request->user_id, $transaction->id))->delay(now()->addMinutes(60));
                return response()->json([
                    'message' => 'Add to transaction success, you must pay it before '. Carbon::create($dateExpired)->format("Y F d H:i:s"),
                ], 200);
            } catch (\Throwable $th) {
                return $th;
                return response()->json([
                    'message' => 'Add to transaction Failed'
                ]);
            }
        }
    }

    public function userHistory($id)
    {
        try {
            $user = User::find($id);
            $transaction = Transaction::with('product')->where('user_id', $id)->orderBy('id', 'desc')->get();

            return response()->json([
                'message' => 'Success',
                'data' => [
                    'user' => $user,
                    'data' => $transaction
                ]
            ], 200);
        } catch (\Throwable $th) {
            // return $th;
            return response()->json([
                'message' => 'Get data failed !'
            ], 400);
        }
    }

    public function paidOrder(Request $request, $id)
    {
        $transaction_paid = Transaction::where('status', 'Pending')->find($id);


        try {
                $transaction_paid->update([
                'status' => 'Proccess'
            ]);

            MailController::orderPaid($request->user_id);
            return response()->json([
                'message' => 'Your order is confirmed paid'
            ]);
        } catch (\Throwable $th) {
            // return $th;
            return response()->json([
                'message' => 'Payment Failed'
            ]);
        }
    }
}
