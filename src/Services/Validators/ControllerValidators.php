<?php declare(strict_types=1);
namespace GWSN\Helpers\Services\Validators;

use Symfony\Component\HttpFoundation\Request;

class ControllerValidators
{

    /**
     * @param int|null $limit
     * @param int $default
     * @return int
     */
    private static function validateLimit(?int $limit, int $default): int {
        if(intval($limit) < 200 && intval($limit) > 25) {
            return $limit;
        }

        return $default;
    }

    /**
     * @param int|null $page
     * @param int $default
     * @return int
     */
    private static function validatePage(?int $page, int $default): int {
        if(intval($page) < 2500 && intval($page) > 0) {
            return $page;
        }

        return $default;
    }

    /**
     * @param Request $request
     * @param string $key
     * @param int $default
     * @return int
     */
    public static function getLimitFromRequest(Request $request, string $key = 'limit', int $default = 25): int {
        return self::validateLimit($request->query->get($key, null), $default);
    }

    /**
     * @param Request $request
     * @param string $key
     * @param int $default
     * @return int
     */
    public static function getPageFromRequest(Request $request, string $key = 'page', int $default = 1): int {
        return self::validatePage($request->query->get($key, null), $default);
    }

    /**
     * @param int $limit
     * @param int $page
     * @return int
     */
    public static function getOffset(int $limit, int $page): int {
        return $limit * ($page - 1);
    }
}
