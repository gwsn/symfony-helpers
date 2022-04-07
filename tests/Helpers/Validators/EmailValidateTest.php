<?php

namespace UnitTests\GWSN\Helpers\Validators;

use GWSN\Helpers\Validators\EmailValidate;
use PHPUnit\Framework\TestCase;

class EmailValidateTest extends TestCase
{

    public function testValidate()
    {
        $accountArray = ['email' => 'test@gwsn.nl', 'password' => 'admin'];

        $result = EmailValidate::validate('email', $accountArray, true);

        $this->assertTrue($result);
    }

    public function testValidateNotRequired()
    {
        $accountArray = ['password' => 'admin'];

        $result = EmailValidate::validate('email', $accountArray, false);

        $this->assertTrue($result);
    }

    public function testValidateDoesNotExist()
    {
        $accountArray = ['password' => 'admin'];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('email does not exist');
        $this->expectExceptionCode(400);

        EmailValidate::validate('email', $accountArray, true);
    }

    public function testValidateDoesNotValid()
    {
        $accountArray = ['email' => 'testgwsn.nl', 'password' => 'admin'];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid email');
        $this->expectExceptionCode(400);

        EmailValidate::validate('email', $accountArray, true);
    }
}
