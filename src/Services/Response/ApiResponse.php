<?php declare(strict_types=1);
namespace GWSN\Helpers\Services\Response;

use Exception;
use GWSN\Helpers\Entity\ApiSettings;
use GWSN\Helpers\Entity\ResponseMetadata;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public ?array $responseData = [];
    public int $responseStatusCode;
    public array $responseHeaders;
    private ResponseMetadata $responseMetadata;


    /**
     * @param array|null $responseData Give the response data as an Array
     * @param int $status The response status code
     * @param array $headers The response headers
     * @param array $metadata Define custom metadata or overwrite the metadata keys
     */
    public function __construct(
        ?array $responseData = null,
        int $status = Response::HTTP_OK,
        array $headers = []
    )
    {
        $this->setResponseData($responseData);
        $this->setResponseStatusCode($status);
        $this->setResponseHeaders($headers);

        $this->setResponseMetadata(new ResponseMetadata(new ApiSettings));

        return $this->getResponse();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response {
        if($this->responseMetadata->getTotal() === null) {
            $this->responseMetadata->setTotal(is_array($this->getResponseData()) ? count($this->getResponseData()) : 0);
        }

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
     * @return array|null
     */
    public function getResponseData(): ?array
    {
        return $this->responseData;
    }

    /**
     * @param array|null $responseData
     * @return ApiResponse
     */
    public function setResponseData(?array $responseData): ApiResponse
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
     * @param bool $success
     * @return ApiResponse
     */
    public function setSuccess(bool $success): ApiResponse
    {
        $this->getResponseMetadata()->setSuccess($success);
        return $this;
    }

    /**
     * @param string $message
     * @return ApiResponse
     */
    public function setInfo(string $message): ApiResponse
    {
        $this->getResponseMetadata()->setInfoMessage($message);
        return $this;
    }

    /**
     * @param string $errorMessage
     * @param int $errorCode
     * @return ApiResponse
     */
    public function setError(string $errorMessage = '', int $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR): ApiResponse
    {
        $this->setSuccess(false)
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
        if(key_exists($errorCode, Response::$statusTexts)) {
            $this->setResponseStatusCode($errorCode);
        }
        
        $this->getResponseMetadata()->setErrorCode($errorCode);
        return $this;
    }

    /**
     * @param string $errorMessage
     * @return ApiResponse
     */
    public function setErrorMessage(string $errorMessage): ApiResponse
    {
        $this->getResponseMetadata()->setErrorMessage($errorMessage);
        return $this;
    }
}
