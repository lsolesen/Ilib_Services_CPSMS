<?php
/**
 * Class for easy use of CPSMS gateway.
 *
 * PHP Version 5
 *
 * @category Services
 * @package  Ilib_Services_CPSMS
 * @author   Sune Jensen <sj@sunet.dk>
 * @author   Lars Olesen <lars@legestue.net>
 */

/**
 * Class for easy use of CPSMS gateway.
 *
 * <code>
 * $sms = new Ilib_Services_CPSMS('username', 'password', 'sendername');
 * $sms->setMessage('Test sms');
 * $sms->addRecipient('12345678');
 * $sms->addRecipient('87654321');
 * $sms->send();
 * </code>
 *
 * @category Services
 * @package  Ilib_Services_CPSMS
 * @author   Sune Jensen <sj@sunet.dk>
 * @author   Lars Olesen <lars@legestue.net>
 *
 */
class Ilib_Services_CPSMS
{
    protected $url;
    protected $message;
    protected $recipient;
    protected $errormessage;

    /**
     * constructor
     *
     * @param string username
     * @param string password
     * @param string sendername
     */
    public function __construct($username, $password, $sendername)
    {
        $this->url  = "http://www.cpsms.dk/sms/";
        $this->url .= "?username=" . $username; // Username
        $this->url .= "&password=" . $password; // Password
        $this->url .= "&from=" . urlencode($sendername); // Sendername

        $this->recipient = array();
        $this->errormessage = '';
    }

    /**
     * Sets the message to be send
     *
     * @param string message Maximum 459 characters
     * @return boolean true or false
     */
    public function setMessage($message)
    {
        if(empty($message)) {
            $this->setErrorMessage('The message is empty');
            return false;
        }

        if(strlen($message) > 459) {
            $this->setErrorMessage('The message is to long. Only 459 characters is allowed.');
            return false;
        }

        $this->message = urlencode($message);
        return true;
    }

    /**
     * Adds recipients to sms
     *
     * @param string recipient Only 8 numeric characters
     * @return boolean true or false
     */
    public function addRecipient($recipient)
    {
        if(!ereg("^[0-9]{8}$", $recipient)) {
            $this->setErrorMessage('Invalid recepient. The number is not 8 numerix characters');
            return false;
        }

        $this->recipient[] = $recipient;
        return true;
    }

    /**
     * Send sms
     *
     * @return boolean true on success
     */
    public function send()
    {
        if(empty($this->message)) {
            $this->setErrorMessage('The message is empty.');
            return false;
        }

        if(!is_array($this->recipient) || empty($this->recipient)) {
            $this->setErrorMessage('No recipients is given.');
            return false;
        }

        $send = "&message=" . $this->message;

        if(count($this->recipient) > 1 ) {
            foreach($this->recipient AS $recipient) {
                $send .= "&recipient[]=" . $recipient; // Recipient
            }
        }
        else {
            $send .= "&recipient=" . $this->recipient[0]; // Recipient
        }

        // The url is opened
        $reply = file_get_contents($this->url.$send);
        if (strstr($reply, "<succes>")) {
            return true;
        } else {
        // If not, there has been an error.
            throw new Exception("The message has NOT been sent. Server response: ".$reply);
        }
    }

    /**
     * Sets an error message on error
     *
     * @param string error message
     * @return void
     */
    protected function setErrorMessage($message)
    {
        $this->errormessage = $message;
    }

    /**
     * Returns an error message after error
     *
     * @return string error message
     */
    public function getErrorMessage()
    {
        return $this->errormessage;
    }
}