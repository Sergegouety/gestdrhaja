<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;
class SendMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $sujet;
    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sujet, $message,$file)
    {
        //
         $this->sujet = $sujet;
         $this->message = $message;
         $this->file = $file;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->markdown('emails.sendmessage');
        $email = $this->from('no-reply@agenceemploijeunes.ci')
                    ->subject($this->sujet)
                    ->markdown('emails.sendmessage')
                    ->with([
                        'message' => $this->message,
                        'sujet' => $this->sujet
                    ]);
                    if($this->file){
                        $email->attach($this->file);
                    }
       return $email;
    }

}
