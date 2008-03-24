<?php
require_once 'config.test.php';

require_once 'PHPUnit/Framework.php';

require_once 'Ilib/Services/CPSMS.php';

class CPSMSTest extends PHPUnit_Framework_TestCase
{
    private $sms;

    function setUp()
    {
        $this->sms = new Ilib_Services_CPSMS(ILIB_SERVICES_CPSMS_TEST_USERNAME, ILIB_SERVICES_CPSMS_TEST_PASSWORD);
    }

    function tearDown()
    {
        unset($this->sms);
    }

    function testConstructor()
    {
        $this->assertTrue(is_object($this->sms));
    }

    function testSendReturnsTrue()
    {
        $this->assertTrue($this->sms->send('Test', ILIB_SERVICES_CPSMS_TEST_PHONE));
    }
}
