<?php

namespace UnitTests\GWSN\Helpers\Validators;

use GWSN\Helpers\Validators\UuidValidator;
use PHPUnit\Framework\TestCase;

class UuidValidatorTest extends TestCase
{

    public function testValidate()
    {
        $uuid = 'b32d2cc4-9c40-45ba-9953-9204cc9903bb';

        $result = UuidValidator::validate($uuid);

        $this->assertTrue($result);
    }

    public function testValidateInvalid()
    {
        $uuid = 'Invalid Uuid';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('Uuid %s is not valid', $uuid));
        $this->expectExceptionCode(400);

        UuidValidator::validate($uuid);
    }
}
