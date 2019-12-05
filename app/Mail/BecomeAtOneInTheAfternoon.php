<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BecomeAtOneInTheAfternoon extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $folder;
    public $task;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $folder, $task)
    {
        $this->user = $user;
        $this->folder = $folder;
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('もうすぐ期限日になるタスクがあります！')
            ->view('mail.unfinish-task');
    }
}
