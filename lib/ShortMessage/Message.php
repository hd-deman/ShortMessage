<?php
namespace ShortMessage;

class Message
{
    private $text;
    private $sourceAddres;
    private $destinationAddress;

    public function __construct($sourceAddres, $destinationAddress, $text)
    {
        $this->sourceAddres = $sourceAddres;
        $this->destinationAddress = $destinationAddress;
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getSourceAddres()
    {
        return $this->sourceAddres;
    }

    public function getDestinationAddress()
    {
        return $this->destinationAddress;
    }
}
