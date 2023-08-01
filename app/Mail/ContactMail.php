<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\model\Contact;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        // return $this->view('view.name');
        $created_at = Contact::orderBy('id','desc')->value('created_at');
        return $this->subject($created_at.' คุณมีข้อความติดต่อใหม่ กรุณาตอบกลับข้อความ!!')->view('emails.ContactMail');

    }
}
