<?php
namespace ShortMessage\Client;

class DevinoClient implements ClientInterface
{

    /**
     * Root REST requests URL
     * @const
     */
    const m_baseURL = "https://integrationapi.net/rest";

    public function __construct()
    {
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
    public static function getSessionID($login, $password )
    {
        $pest = new Pest(SMSClient::m_baseURL);
        $sessionID = "";
        try {
            $sessionID = str_replace('"', '',
            $pest->get('/User/SessionId?login='.$login.'&password='.$password)
            );
        } catch ( Exception $e ) {
            $errorInfo = json_decode($e->getMessage());
            unset($pest);
            throw( new SMSError_Exception( $errorInfo->Desc, $errorInfo->Code));
        }
        unset($pest);

        return $sessionID;
    }
}
