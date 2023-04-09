<?php

namespace App\Mail;

use App\Models\ContactMessage;
use App\Traits\QueueMailConstants;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Log;

class ContactFormMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    use QueueMailConstants;

    public $contactMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::channel('emails-sent')->info('Contact Form Message alert sent to ' . $this->contactMessage->email);

        $config = $this->noReplyEmail();

        return $this->from($config['email'], $config['name'])
            ->subject('Contact Form Submission')
            ->markdown('emails.contact-form-email');
    }
}
