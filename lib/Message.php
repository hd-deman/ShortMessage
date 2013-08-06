<?php
namespace ShortMessage;

class Message
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this;
    }
}
