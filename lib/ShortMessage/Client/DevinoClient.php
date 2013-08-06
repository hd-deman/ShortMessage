<?php
namespace ShortMessage\Client;

use ShortMessage\Message;
use Buzz\Browser;

class DevinoClient implements ClientInterface
{

    /**
     * Root REST requests URL
     * @const
     */
    const BASE_URL = "https://integrationapi.net/rest";

    private $buzz;

    public function __construct(Browser $buzz)
    {
        $this->buzz = $buzz;
    }

    /**
     * Session ID Queue
     *
     * @access public
     * @static
     *
     * @param string $login    User name
     * @param string $password Password
     *
     * @return string          Session ID
     * @throws DevinoException
     */
    public function getSessionId($login, $password)
    {
        $sessionId = "";
        try {
            $response = $this->buzz->get(self::BASE_URL.'/User/SessionId?login='.$login.'&password='.$password);

            $sessionId = str_replace('"', '', $response->getContent());
        } catch (\Exception $e) {
            $sessionId = json_decode($e->getMessage());
            throw ( new \Exception($errorInfo->Desc, $errorInfo->Code));
        }

        return $sessionId;
    }

    public function send(Message $message)
    {
    }
}
