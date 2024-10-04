<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use App\Mail\SendMailsToUsers;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail()
    {
        $details = [
            'title' => 'Mail from veronica',
            'body' => 'This is for testing'
        ];

        Mail::to("receivermail@gmail.com")->send(new SendMailsToUsers($details));
        return "Email sent";
    }
}
