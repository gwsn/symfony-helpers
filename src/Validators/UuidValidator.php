<?php declare(strict_types=1);
namespace GWSN\Helpers\Validators;

class UuidValidator
{
    /**
     * Validate strings
     *
     * @param string|null $uuid
     * @return bool
     * @throws \Exception
     */
    public static function validate(string $uuid = null): bool {
        $validateRegex = "/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/";

        // Check if the salutation is valid
        if(preg_match( $validateRegex, $uuid, $matches ) !== 1 ) {
            throw new \Exception(sprintf('Uuid %s is not valid', $uuid));
        }
        return true;
    }
}
