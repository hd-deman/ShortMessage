<?php
namespace ShortMessage;
use ShortMessage\Client\ClientInterface;

class Messenger
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendMessage($text, $sourceAddres, $destinationAddress)
    {
        $message = new Message($text, $phone, $sourceAddres);

        return $this->client->send($message);
    }
}
