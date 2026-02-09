<?php

namespace App\Console\Commands;

use App\User;
use App\Candidate;
use Illuminate\Console\Command;
use App\Mail\Register;
use Illuminate\Support\Facades\Mail;

class sendRegisterMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-register-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send registration emails to candidates who have not received them yet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users=User::where('register_mail_sent', false)->get();
        foreach($users as $user){
            $candidate=Candidate::where('user_id',$user->id)->first();
            if (!empty($candidate)) {
                Mail::to($candidate->email,$candidate->name)->send(new Register($candidate));
                $user->register_mail_sent=1;
                $user->save();
            }
        }
    }
}
