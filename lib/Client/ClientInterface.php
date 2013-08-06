<?php

namespace ShortMessage\Client;

use ShortMessage\Message;

interface ClientInterface
{
    /**
     * Send sms.
     *
     * @param Message $message A message object
     */
    public function send(Message $message);
}
