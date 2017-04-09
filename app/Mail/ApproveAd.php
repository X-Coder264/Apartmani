<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApproveAd extends Mailable
{
    use Queueable, SerializesModels;

    protected $user, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verificationAd')
            ->with([
                'user' => $this->user->name,
                'messageSend' => $this->message,
            ]);
    }
}
