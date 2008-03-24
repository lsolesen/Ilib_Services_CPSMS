<?php
class Ilib_Services_CPSMS
{
    private $url;

    public function __construct($username, $password)
    {
        $this->url  = "http://www.cpsms.dk/sms/";
        $this->url .= "?username=" . $username; // Username
        $this->url .= "&password=" . $password; // Password
        $this->url .= "&from=" . urlencode("Sendername"); // Sendername
    }

    public function send($message, $recipient)
    {
        $this->url .= "&message=" . urlencode($message);
        $this->url .= "&recipient=" . $recipient; // Recipient
        // The url is opened
        $reply = file_get_contents($this->url);
        if (strstr($reply, "<succes>")) {
            return true;
        } else {
        // If not, there has been an error.
            throw new Exception("The message has NOT been sent. Server response: ".$reply);
        }
    }
}