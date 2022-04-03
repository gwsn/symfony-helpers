<?php declare(strict_types=1);

namespace GWSN\Helpers\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    /**
     * @param array|null $responseData
     * @param ResponseResult|null $responseResult
     * @param int $status The response status code
     * @param array $headers An array of response headers
     * @param array $metadata
     */
    public function __construct(
        $responseData = null,
        ResponseResult $responseResult = null,
        int $status = 200,
        array $headers = [],
        array $metadata = []
    )
    {
        $metadata = array_merge([
            'version' => '1.0.0',
            'api' => 'Batch System API',
            'auth' => 'V1',
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
