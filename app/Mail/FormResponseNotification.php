<?php

namespace App\Mail;

use App\FormResponse;
use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormResponseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $formResponse;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FormResponse $formResponse)
    {
        $this->formResponse = $formResponse;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Form Response: ' .($this->formResponse->form->name));

        if (Storage::disk('active')->exists('FormResponseNotification.blade.php')) {
            return $this->view('active.FormResponseNotification');
        }

        return $this->view('emails.FormResponseNotification');
    }
}
