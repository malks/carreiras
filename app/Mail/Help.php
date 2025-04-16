<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Help extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->contact=$contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('servicos.email2@lunelli.com.br',$this->contact['contact_name']." | Ajuda Luneli Carreiras")
        ->subject($this->contact['contact_subject'])
        ->view('help_mail')->with([
            'contact'=>$this->contact,
        ]);
    }
}
