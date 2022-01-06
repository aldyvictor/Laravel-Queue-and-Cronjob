<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public $title, $email, $name, $expire;
    public $details;
    public function __construct($details)
    {
        // $this->title = $title;
        // $this->email = $email;
        // $this->name = $name;
        // $this->expire = $expire;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // if ($this->title == 'NewOrder') {
        //     return $this->markdown('mail.newOrder')
        //                     ->with([
        //                         'email' => $this->email,
        //                         'name' => $this->name,
        //                         'expire' => $this->expire
        //                     ]);
        // } elseif ($this->title == 'ExpiredOrder') {
        //    return $this->markdown('mail.ExpiredOrder')
        //                     ->with([
        //                         'email' => $this->email,
        //                         'name' => $this->name,
        //                         'expire' => $this->expire
        //                     ]);
        // }
        return $this->subject($this->details['subject'])->markdown('mail.FrontMail')->with($this->details);
    }
}
