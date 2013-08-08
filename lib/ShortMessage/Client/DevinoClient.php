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

    private static $buzz;
    private static $sessionId;

    public function __construct(Browser $buzz, $config)
    {
        self::$buzz = $buzz;
        self::$sessionId = self::getsessionIdApiCall($config['login'], $config['password']);
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
    public static function getsessionIdApiCall($login, $password)
    {
        $sessionId = "";
        try {
            $response = self::$buzz->get(self::BASE_URL.'/User/sessionId?login='.$login.'&password='.$password);

            $sessionId = str_replace('"', '', $response->getContent());
        } catch (\Exception $e) {
            $errorInfo = json_decode($e->getMessage());
            throw (new \Exception($errorInfo->Desc, $errorInfo->Code));
        }

        return $sessionId;
    }

    /**
     * SMS send
     *
     * @access public
     * @static
     *
     * @param string  $sessionId          Session ID. @see getsessionId_St
     * @param string  $sourceAddres       sender name(up to 11 chars) or phone number(up to 15 digits)
     * @param string  $destinationAddress destination phone. Country code+cellular code+phone number, E.g. 79031234567
     * @param string  $data               message
     * @param mixed   $sendDate           Delayed message send date and time. String format YYYY-MM-DDTHH:MM:SS or integer Timestamp. Optional.
     * @param integer $validity           Message life time in minutes. Optional.
     *
     * @return array              SMS IDs
     * @throws SMSError_Exception
     */
    public static function sendApiCall($sessionId, $sourceAddres, $destinationAddress, $data, $sendDate = null, $validity = 0)
    {
        $result = array();
        try {
            $response = self::$buzz->post(
                self::BASE_URL.'/Sms/Send',
                [],
                self::createRequestParameters($sessionId, $sourceAddres, $destinationAddress, $data, $sendDate, $validity)
            );
            $result = json_decode($response->getContent(), true);
        } catch (Exception $e) {
            $errorInfo = json_decode($e->getMessage());
            throw(new \Exception($errorInfo->Desc, $errorInfo->Code));
        }

        return $result;
    }

    public function send(Message $message)
    {
        return self::sendApiCall(self::$sessionId, $message->getSourceAddres(), $message->getDestinationAddress(), $message->getText());
    }

    /**
     * SMS send request parameters preparation
     *
     * @access public
     * @static
     *
     * @param string  $sessionId          Session ID. @see getsessionId_St
     * @param string  $sourceAddres       sender name(up to 11 chars) or phone number(up to 15 digits)
     * @param string  $destinationAddress destination phone. Country code+cellular code+phone number, E.g. 79031234567
     * @param string  $data               message
     * @param mixed   $sendDate           Delayed message send date and time. String format YYYY-MM-DDTHH:MM:SS or integer Timestamp.
     * @param integer $validity           Message life time in minutes.
     *
     * @return array     POST request parameters
     * @throws Exception
     */
    protected static function createRequestParameters($sessionId, $sourceAddres, $destinationAddress, $data, $sendDate = null, $validity = 0)
    {
        $parameters = array(
            'sessionId' => $sessionId,
            'sourceAddress' => $sourceAddres,
            'data' => $data
        );

        if (gettype($destinationAddress) == "string") {

            $parameters['destinationAddress'] = $destinationAddress;

        } elseif (gettype($destinationAddress) == "array") {
            $parameters['destinationAddresses'] = $destinationAddress;
        }

        if (gettype($sendDate) == "string") {
            $parameters['sendDate'] = $sendDate;
        } elseif (gettype($sendDate) == "integer") {
            $parameters['sendDate'] = date("Y-m-d", $sendDate).'T'.date("H:i:s", $sendDate);
        }

        if ((gettype($validity) == "integer") && ($validity != 0)) {
            $parameters['validity'] = $validity;
        }

        return $parameters;
    }
}
