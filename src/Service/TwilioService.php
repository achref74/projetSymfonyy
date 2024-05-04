<?php
namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $twilioClient;

    public function __construct(string $sid, string $token)
    {
        $this->twilioClient = new Client($sid, $token);
    }

    public function sendMessage(string $to, string $from, string $body):string
    {
        return $this->twilioClient->messages->create(
            $to,
            [
                "from" => $from,
                "body" => $body
            ]
        );
    }
}
