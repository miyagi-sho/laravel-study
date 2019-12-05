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
    public $folders;
    public $tasks;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $reminder_folders, $reminder_tasks)
    {
        $this->user = $user;
        $this->folders = $reminder_folders;
        $this->tasks = $reminder_tasks;
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
