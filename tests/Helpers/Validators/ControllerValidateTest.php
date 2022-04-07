<?php
namespace UnitTests\GWSN\Helpers\Validators;

use GWSN\Helpers\Validators\ControllerValidators;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ControllerValidateTest extends TestCase
{

    public function setUp(): void
    {
        $this->request = new Request([
            'limit' => 123,
            'page' => 2,
            'limitCustom' => 124,
            'pageCustom' => 4
        ], [], [], [], [], [], json_encode([]));
        $this->request->setSession(
            new Session(new MockArraySessionStorage())
        );
        $this->invalidRequest = new Request([
            'limit' => 5,
            'page' => 5000
        ], [], [], [], [], [], json_encode([]));
        $this->invalidRequest->setSession(
            new Session(new MockArraySessionStorage())
        );
    }

    public function testGetLimitFromRequest()
    {
        $result = ControllerValidators::getLimitFromRequest($this->request);

        $this->assertEquals(123, $result);
    }

    public function testGetLimitFromRequestGetDefault()
    {
        $result = ControllerValidators::getLimitFromRequest($this->invalidRequest, 'limit', 35);

        $this->assertEquals(35, $result);
    }

    public function testGetPageFromRequest()
    {
        $result = ControllerValidators::getPageFromRequest($this->request);

        $this->assertEquals(2, $result);
    }

    public function testGetPageFromRequestGetDefault()
    {
        $result = ControllerValidators::getPageFromRequest($this->invalidRequest, 'page', 35);

        $this->assertEquals(35, $result);
    }

    public function testGetOffset()
    {
        $result = ControllerValidators::getOffset(10, 10);

        $this->assertEquals(90, $result);
    }
}
