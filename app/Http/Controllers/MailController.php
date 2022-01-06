<?php

namespace App\Http\Controllers;

use App\Mail\SendMailNotification;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function expiredDate($id)
    {
        // $email = User::find($id)->email;
        // $name = User::find($id)->name;
        $expire = Transaction::orderBy('created_at', 'desc')->where('user_id', $id)->first()->expired_at;
        // Mail::to($email)->send(new SendMailNotification('NewOrder', $email, $name, $expire));
         $user = User::with('UserTransaction')->find($id);

         $details = array (
            'email' => $user->email,
            'name' => $user->name,
            'subject' => 'Order Created',
            'header' => '# Your Order has been Created',
            'content' => '<p>We have been recieve your order</p> <br>
                            <p>Please finish your payment before <b>'.$expire.'</b></p><br>
                            <p>So we can proccess it soon</p>',
            'expire' => $expire
        );
        Mail::to($details['email'])->send(new SendMailNotification($details));
    }

    public static function orderPaid($id)
    {
         $user = User::with('UserTransaction')->find($id);

         $details = array (
            'email' => $user->email,
            'name' => $user->name,
            'subject' => 'Order Paid',
            'header' => '# Your order is confirmed paid',
            'content' => '<p>We have been confirmed your order</p> <br>
                            <p>We will process your order immediately<br>
                            <p>Thank you for trusting us</p>',
        );
        Mail::to($details['email'])->send(new SendMailNotification($details));
    }
}
