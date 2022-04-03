<?php

namespace UnitTests\GWSN\Helpers\Validators;

use GWSN\Helpers\Validators\EmailValidate;
use GWSN\Helpers\Validators\StringValidate;
use PHPUnit\Framework\TestCase;

class StringValidateTest extends TestCase
{

    public function testValidate()
    {
        $accountArray = ['username' => 'Admin', 'password' => 'admin'];

        $result = StringValidate::validate('username', $accountArray, true);

        $this->assertTrue($result);
    }

    public function testValidateNotRequired()
    {
        $accountArray = ['password' => 'admin'];

        $result = StringValidate::validate('username', $accountArray, false);

        $this->assertTrue($result);
    }

    public function testValidateDoesNotExist()
    {
        $accountArray = ['password' => 'admin'];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('username does not exist');

        StringValidate::validate('username', $accountArray, true);
    }

    public function testValidateDoesNotValid()
    {
        $accountArray = ['username' => 'Admin~`', 'password' => 'admin'];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid username');

        StringValidate::validate('username', $accountArray, true);
    }
}

