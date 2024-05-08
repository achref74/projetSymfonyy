<?php
namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $sid;
    private $token;
    private $twilioClient;

    public function __construct()
    {
        $this->sid = "AC4e5f1adcb461e2596f8393475dcc7cd1";
        $this->token = "475503393708dc083f3ff3b6058c8e57";
        $this->twilioClient = new Client($this->sid, $this->token);
    }

    public function sendWhatsAppMessage($to, $from, $body)
    {
        return $this->twilioClient->messages->create(
            "whatsapp:$to",
            array(
                "from" => "whatsapp:$from",
                "body" => $body
            )
        );
    }
}
?>