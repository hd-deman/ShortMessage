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

    public function sendMessage($sourceAddres, $destinationAddress, $text)
    {
        $message = new Message($sourceAddres, $destinationAddress, $text);

        return $this->client->send($message);
    }
}
