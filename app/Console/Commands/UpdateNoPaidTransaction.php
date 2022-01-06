<?php

namespace App\Console\Commands;

use App\Jobs\UpdatePendingToNoPaid;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateNoPaidTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command if order date expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $dateNow = Carbon::now()->format("Y F d H:i:s");
        // $transaction = Transaction::with('user')->where('expired_at', '<', $dateNow)
        //                                         ->where('status', 'Pending')
        //                                         ->orderBy('created_at', 'asc')
        //                                         ->first();

        // if ($transaction->save()) {
        //     $details = [
        //         'email' => $transaction->user->email,
        //         'name' => $transaction->user->user,
        //         'transaction_id' => $transaction->id,
        //         'subject' => 'Transaction Expired',
        //         'Content' => 'Your transaction alredy expired, please reorder again'
        //     ];

        //     UpdatePendingToNoPaid::dispatch($details);

        //     $result['data'] = $transaction;
        //     $this->line(json_encode($result));
        // }
    }
}
