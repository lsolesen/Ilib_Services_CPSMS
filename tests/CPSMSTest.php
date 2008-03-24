<?php
require_once 'config.test.php';

require_once 'PHPUnit/Framework.php';

require_once 'Ilib/Services/CPSMS.php';

class CPSMSTest extends PHPUnit_Framework_TestCase
{
    private $sms;

    function setUp()
    {
        $this->sms = new Ilib_Services_CPSMS(ILIB_SERVICES_CPSMS_TEST_USERNAME, ILIB_SERVICES_CPSMS_TEST_PASSWORD, 'CPSMS_TEST');
    }

    function tearDown()
    {
        unset($this->sms);
    }

    function testConstructor()
    {
        $this->assertTrue(is_object($this->sms));
    }
    
    function testAddInvalidRecipientReturnsFalse()
    {
        $this->assertFalse($this->sms->addRecipient('123456'));
    }
    
    function testAddValidRecipientReturnsTrue()
    {
        $this->assertTrue($this->sms->addRecipient('12345678'));
    }

    function testSendReturnsTrue()
    {
        $this->sms->setMessage('Test');
        $this->sms->addRecipient(ILIB_SERVICES_CPSMS_TEST_PHONE);
        $this->assertTrue($this->sms->send(), $this->sms->getErrorMessage());
    }
    
    function testSendToMultipleRecipientsReturnsTrue() {
        $this->sms->setMessage('Test');
        $this->sms->addRecipient(ILIB_SERVICES_CPSMS_TEST_PHONE);
        $this->sms->addRecipient(ILIB_SERVICES_CPSMS_TEST_PHONE);
        $this->assertTrue($this->sms->send(), $this->sms->getErrorMessage());
    }
}
