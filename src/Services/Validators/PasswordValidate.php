<?php declare(strict_types=1);
namespace GWSN\Helpers\Services\Validators;

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
        if (!preg_match("/[A-Z]/", $password)) {
            throw new Exception("Password must contain at least one uppercase letter.", 400);
        }
        if (!preg_match("/[a-z]/", $password)) {
            throw new Exception("Password must contain at least one lowercase letter.", 400);
        }
        if (!preg_match("/[0-9]/", $password)) {
            throw new Exception("Password must contain at least one digit.", 400);
        }
        if (!preg_match("/\W/", $password)) {
            throw new Exception("Password must contain at least one special character.", 400);
        }
        if (strlen($password) < $length) {
            throw new Exception("Password must be at least 8 characters long.", 400);
        }

        return true;
    }
}
