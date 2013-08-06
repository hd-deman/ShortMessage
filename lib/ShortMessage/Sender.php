<?php
namespace ShortMessage;
use ShortMessage\Client\ClientInterface;

class Sender
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendMessage($text, $phone)
    {
        $message = new Message($text, $phone);

        return $this->client->send($message);
    }
}
