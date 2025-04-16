<?php

namespace App\Mail;

use App\Candidate;
use App\Job;
use App\StateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Register extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Candidate $candidate)
    {
        $this->candidate=$candidate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data=StateMail::first();
        return $this
        ->from('servicos.email2@lunelli.com.br','Recrutamento Lunelli')
        ->subject('Seja bem vindo(a) ao Lunelli Carreiras!')
        ->view('adm.states_mails.mail')->with([
            'candidate'=>$this->candidate,
            'job'=>new Job,
            'data'=>$data,
        ]);
    }
}