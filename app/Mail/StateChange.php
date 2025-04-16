<?php

namespace App\Mail;

use App\Candidate;
use App\Job;
use App\State;
use App\StateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StateChange extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Candidate $candidate,Job $job,State $state)
    {
        $this->candidate=$candidate;
        $this->job=$job;
        $this->state=$state;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data=StateMail::join('states_mails_states','states_mails_states.mail_id','=','states_mails.id')->where('states_mails_states.state_id','=',$this->state->id)->orderBy('states_mails_states.updated_at','desc')->first();
        if (!empty($data)){
            return $this
            ->from('servicos.email2@lunelli.com.br','Lunelli Carreiras')
            ->subject($data->subject.' | Lunelli Carreiras')
            ->view('adm.states_mails.mail')->with([
                'candidate'=>$this->candidate,
                'job'=>$this->job,
                'data'=>$data,
            ]);
        }
    }
}
