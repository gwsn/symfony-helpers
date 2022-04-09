<?php declare(strict_types=1);
namespace GWSN\Helpers\Services\Validators;


class StringValidate
{
    /**
     * Validate strings
     *
     * @param string|null $key
     * @param array $source
     * @param bool $required
     * @param int $minLength
     * @param int $maxLength
     *
     * @return bool
     * @throws \Exception
     */
    public static function validate(string $key = null, array $source = [], bool $required = false, int $minLength = 0, int $maxLength = 254): bool {
        $validateRegex    = "/^[a-zA-ZÀ-ž0-9#$^+=!?\'\"\-\.\,\:\;\/\_*\(\)\[\]@%&\\\\\s]{".$minLength.",".$maxLength."}$/";

        if(!$required && (!key_exists($key, $source) || $source[$key] === null )) {
            return true;
        }
        if($required && (!key_exists($key, $source) || $source[$key] === null )) {
            throw new \Exception($key . ' does not exist', 400);
        }
        if(! (preg_match( $validateRegex, $source[$key], $matches ) === 1))
        {
            throw new \Exception('Invalid ' . $key, 400);
        }

        // Check if the String is valid
        return true;
    }
}
