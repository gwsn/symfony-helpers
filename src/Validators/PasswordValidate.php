<?php declare(strict_types=1);
namespace GWSN\Helpers\Validators;

use Exception;

class PasswordValidate
{
    /**
     * @param string $password
     * @param int $length
     * @return bool
     * @throws Exception
     */
    public static function validate(string $password, int $length): bool
    {
        $uppercase = preg_match('/[A-Z]/', $password);
        $lowercase = preg_match('/[a-z]/', $password);
        $number    = preg_match('/[0-9]/', $password);
        $specialChars = preg_match('/[^\w]/', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < $length) {
            throw new Exception('Password not valid');
        }

        return true;
    }
}
