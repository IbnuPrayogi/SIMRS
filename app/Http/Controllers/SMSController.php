<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function sendSMS(){
        $basic  = new \Vonage\Client\Credentials\Basic("53707006", "Qo6yGVXk2kVmaeoO");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("62895606159225", "Indonesia", 'Pesan Ini Hanya Percobaan')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
