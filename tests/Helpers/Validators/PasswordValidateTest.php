<?php

namespace UnitTests\GWSN\Helpers\Validators;

use Exception;
use GWSN\Helpers\Validators\PasswordValidate;
use PHPUnit\Framework\TestCase;

class PasswordValidateTest extends TestCase
{
    /**
     * @return array
     */
    public function validateProvider() : array
    {
        $providerData = [];

        // Test validate without change on array
        $password = 'Test123!';
        $providerData[] = [$password, true];

        $password = 'test123!';
        $providerData[] = [$password, false];

        $password = 'TEST123!';
        $providerData[] = [$password, false];

        $password = 'Test1234';
        $providerData[] = [$password, false];

        $password = 'TestTest';
        $providerData[] = [$password, false];

        $password = 'Test';
        $providerData[] = [$password, false];

        return $providerData;
    }

    /**
     * @param string $password
     * @param bool $validateTrue
     * @throws Exception
     * @dataProvider validateProvider
     */
    public function testValidate(string $password, bool $validateTrue)
    {
        if($validateTrue === true) {
            $result = PasswordValidate::validate($password, 8);
            $this->assertTrue($result);
        } else {
            $this->expectException(Exception::class);
            $this->expectExceptionMessage('Password not valid');
            PasswordValidate::validate($password, 8);
        }

    }
}
