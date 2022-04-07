<?php declare(strict_types=1);
namespace GWSN\Helpers\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    private ApiSettings $apiSettings;

    /**
     * @param array|null $responseData
     * @param ResponseResult|null $responseResult
     * @param int $status The response status code
     * @param array $headers An array of response headers
     * @param array $metadata
     * @param ApiSettings|null $apiSettings
     */
    public function __construct(
        $responseData = null,
        ResponseResult $responseResult = null,
        int $status = 200,
        array $headers = [],
        array $metadata = [],
        ApiSettings $apiSettings = null
    )
    {
        if($apiSettings === null) {
            $apiSettings = new ApiSettings(null);
        }


        $metadata = array_merge([
            'version' => $apiSettings->getApplicationVersion(),
            'api' => $apiSettings->getApplicationName(),
            'auth' => $apiSettings->getApplicationAuthVersion(),
            'success' => $responseResult->isSuccess(),
            'error' => ($responseResult->isError() ? [
                'code' => $responseResult->getErrorCode(),
                'message' => $responseResult->getErrorMessage()
            ] : null),
        ], $metadata);


        $data = [
            'data' => $responseData,
            'meta' => $metadata,
            'status' => $status
        ];

        parent::__construct($data, $status, $headers, false);
    }
}
