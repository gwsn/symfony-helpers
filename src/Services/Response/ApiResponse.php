<?php declare(strict_types=1);
namespace GWSN\Helpers\Services\Response;

use Exception;
use GWSN\Helpers\Entity\ApiSettings;
use GWSN\Helpers\Entity\ResponseMetadata;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public array $responseData;
    public int $responseStatusCode;
    public array $responseHeaders;
    public ResponseMetadata $responseMetadata;
    public ApiSettings $apiSettings;


    /**
     * @param array|null $responseData Give the response data as an Array
     * @param int $status The response status code
     * @param array $headers The response headers
     * @param array $metadata Define custom metadata or overwrite the metadata keys
     * @param ApiSettings|null $apiSettings
     */
    public function __construct(
        ?array $responseData = null,
        int $status = Response::HTTP_OK,
        array $headers = [],
        array $metadata = [],
        ApiSettings $apiSettings = null
    )
    {
        $this->setResponseData($responseData);
        $this->setResponseStatusCode($status);
        $this->setResponseHeaders($headers);
        $this->setApiSettings(($apiSettings ?? $this->apiSettings = new ApiSettings(null)));
        $this->setResponseMetadata(new ResponseMetadata($metadata, $this->getApiSettings()));

        return $this->getResponse();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response {
        $data = [
            'data' => $this->getResponseData(),
            'meta' => $this->getResponseMetadata()->toArray(),
            'status' => $this->getResponseStatusCode()
        ];

        return new JsonResponse(
            $data,
            $this->getResponseStatusCode(),
            $this->getResponseHeaders(),
            false
        );
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return $this->responseData;
    }

    /**
     * @param array $responseData
     * @return ApiResponse
     */
    public function setResponseData(array $responseData): ApiResponse
    {
        $this->responseData = $responseData;
        return $this;
    }

    /**
     * @return int
     */
    public function getResponseStatusCode(): int
    {
        return $this->responseStatusCode;
    }

    /**
     * @param int $responseStatusCode
     * @return ApiResponse
     */
    public function setResponseStatusCode(int $responseStatusCode): ApiResponse
    {
        $this->responseStatusCode = $responseStatusCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * @param array $responseHeaders
     * @return ApiResponse
     */
    public function setResponseHeaders(array $responseHeaders): ApiResponse
    {
        $this->responseHeaders = $responseHeaders;
        return $this;
    }

    /**
     * @return array
     */
    public function getResponseMetadata(): ResponseMetadata
    {
        return $this->responseMetadata;
    }

    /**
     * @param ResponseMetadata $responseMetadata
     * @return ApiResponse
     */
    public function setResponseMetadata(ResponseMetadata $responseMetadata): ApiResponse
    {
        $this->responseMetadata = $responseMetadata;
        return $this;
    }

    /**
     * @param array $customMetadata
     * @return ApiResponse
     */
    public function setCustomMetadata(array $customMetadata): ApiResponse
    {
        $this->setCustomMetadata($customMetadata);
        return $this;
    }

    /**
     * @return ApiSettings
     */
    public function getApiSettings(): ApiSettings
    {
        return $this->responseMetadata->getApiSettings();
    }

    /**
     * @param ApiSettings $apiSettings
     * @return ApiResponse
     */
    public function setApiSettings(ApiSettings $apiSettings): ApiResponse
    {
        $this->responseMetadata->setApiSettings($apiSettings);
        return $this;
    }

    /**
     * @param bool $success
     * @return ApiResponse
     */
    public function setSuccess(bool $success): ApiResponse
    {
        $this->responseMetadata->setSuccess($success);
        return $this;
    }

    /**
     * @param string $message
     * @return ApiResponse
     */
    public function setMessage(string $message): ApiResponse
    {
        $this->responseMetadata->setMessage($message);
        return $this;
    }

    /**
     * @param string $errorMessage
     * @param int $errorCode
     * @return ApiResponse
     */
    public function setError(string $errorMessage = '', int $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR): ApiResponse
    {
        $this->responseMetadata
            ->setSuccess(false)
            ->setErrorMessage($errorMessage)
            ->setErrorCode($errorCode);

        return $this;
    }

    /**
     * @param Exception $exception
     * @return ApiResponse
     */
    public function setErrorFromException(Exception $exception): ApiResponse
    {
        $this->setError($exception->getMessage(), ($exception->getCode() === 0 ? 500 : $exception->getCode()));
        return $this;
    }

    /**
     * @param int $errorCode
     * @return ApiResponse
     */
    public function setErrorCode(int $errorCode): ApiResponse
    {
        $this->responseMetadata->setErrorCode($errorCode);
        return $this;
    }

    /**
     * @param string $errorMessage
     * @return ApiResponse
     */
    public function setErrorMessage(string $errorMessage): ApiResponse
    {
        $this->responseMetadata->setErrorMessage($errorMessage);
        return $this;
    }
}
