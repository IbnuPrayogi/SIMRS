<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class ChatController extends Controller
{
    //

    public function sendWhatsAppMessage()
    {
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_FROM');
        $recipientNumber = 'whatsapp:+6287794052070';
        $message = "WHATSAPP ANDA TELAH DI HACK , SEGERA HUBUNGI 087794052070";

        $twilio = new Client($twilioSid, $twilioToken);


        try {
            $twilio->messages->create(
                $recipientNumber,
                [
                    "from" =>"whatsapp:".$twilioWhatsAppNumber,
                    "body" => $message,
                ]
            );

            return response()->json(['message' => 'WhatsApp message sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sendSMS(){
        $basic  = new \Vonage\Client\Credentials\Basic("53707006", "Qo6yGVXk2kVmaeoO");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("6287794052070", BRAND_NAME, 'A text message sent using the Nexmo SMS API')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

}
