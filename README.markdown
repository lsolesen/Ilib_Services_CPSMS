PHP-library to talk to the [CPSMS-gateway](https://www.cpsms.dk/)
==

Usage
--

    $sms = new Ilib_Services_CPSMS('username', 'password', 'sendername');
    $sms->setMessage('Test sms');
    $sms->addRecipient('12345678');
    $sms->addRecipient('87654321');
    $sms->send();
