<?php

namespace App\Jobs;

use App\Mail\SendMailNotification;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class UpdatePendingToNoPaid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user_id, $transaction_id;
    // protected $details;
    public function __construct($user_id, $transaction_id)
    {
        $this->user_id = $user_id;
        $this->transaction_id = $transaction_id;
        // $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $expiredOrder = Carbon::now()->format("Y F d H:i:s");
        // $email = User::find($this->user_id)->email;
        // $name = User::find($this->user_id)->name;
        // $expire = Transaction::orderBy('created_at', 'desc')->where('user_id', $this->user_id)->first()->expired_at;
        // $transaction = Transaction::find($this->transaction_id);
        // if ($expiredOrder > $transaction->expired_at) {
        //     $updateTransaction->update([
        //         'status' => 'No Paid'
        //     ]);
        //     Mail::to($email)->send(new SendMailNotification('ExpiredOrder', $email, $name, $expire));
        // }

        // $expiredOrder = Carbon::now()->format("Y F d H:i:s");
        // $expire = Transaction::orderBy('expired_at', 'desc')->where('status', 'Pending')->where('expired_at', '<', $expiredOrder)->first();
        // $user = Transaction::orderBy('expired_at', 'desc')->where('status', 'Pending')->where('expired_at', '<', $expiredOrder)->first();
        // $email = User::find($user)->email;
        // $name = User::find($user)->name;

        // if ($expiredOrder > $expire->expired_at) {
        //     $updateTransaction->update([
        //         'status' => 'No Paid'
        //     ]);

        //     Mail::to($email)->send(new SendMailNotification('ExpiredOrder', $email, $name, $expire));
        // }
        // $email = new SendMailNotification($this->details);
        // Mail::to($this->details['email'])->send($email);
        $transaction = Transaction::find($this->transaction_id);
        if ($transaction->status == 'Pending') {
            Transaction::find($this->transaction_id)->update([
                'status' => 'No Paid'
            ]);
            $user = User::find($this->user_id);

             $details = array (
                'email' => $user->email,
                'name' => $user->name,
                'subject' => 'Order Expired',
                'header' => '# Your Order Already Expired',
                'content' => '<p>We are sorry, your order already expired </p> <br>
                                <p>Please, re-order the product do you want to buy</p><br>
                                <p>So that we proccess immediately</p>',
            );
            Mail::to($details['email'])->send(new SendMailNotification($details));
            return 'Email Sended';
        }
    }
}
