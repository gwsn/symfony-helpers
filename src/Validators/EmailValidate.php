<?php
namespace GWSN\Helpers\Validators;


class EmailValidate
{


    /**
     * @param string $key
     * @param array $source
     * @param bool $required
     *
     * @return bool
     * @throws \Exception
     */
    public static function validate(string $key = null, array $source = [], bool $required = false): bool {
        if(!$required && (!key_exists($key, $source) || $source[$key] === null )) {
            return true;
        }
        if($required && !key_exists($key, $source)) {
            throw new \Exception($key . ' does not exist', 400);
        }
        if(! filter_var($source[$key], FILTER_VALIDATE_EMAIL))
        {
            throw new \Exception('Invalid ' . $key, 400);
        }
        return true;
    }
}
