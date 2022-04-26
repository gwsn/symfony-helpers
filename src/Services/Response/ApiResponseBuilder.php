<?php declare(strict_types=1);
namespace GWSN\Helpers\Services\Response;

use Exception;
use GWSN\Helpers\Entity\ApiResponse;
use GWSN\Helpers\Entity\ApiResponseData;
use GWSN\Helpers\Entity\ApiSettings;
use GWSN\Helpers\Entity\ApiResponseMetadata;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseBuilder
{

    /** @var ApiResponse|null */
    private ?ApiResponse $apiResponse = null;

    /**
     * Build new Api response to start with
     */
    public function __construct()
    {
        $this->getNewApiResponse();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response {
        $this->buildMetadata();

        return $this->apiResponse->getResponse();
    }

    /**
     * @return void
     */
    public function buildMetadata() {
        $responseData = $this->getApiResponseData()->getResponseData();

        if($this->getApiResponseMetadata()->getTotal() === null) {
            $this->getApiResponseMetadata()->setTotal(is_array($responseData) ? count($responseData) : 0);
        }
    }

    /**
     * @return ApiResponse
     */
    public function getNewApiResponse(): ApiResponse {
        $apiResMeta = new ApiResponseMetadata(new ApiSettings);
        $apiResData = new ApiResponseData([], $apiResMeta, Response::HTTP_OK);

        $this->apiResponse = new ApiResponse($apiResData);
        return $this->apiResponse;
    }

    /**
     * @return ApiResponse
     */
    public function getApiResponse(): ApiResponse {
        if($this->apiResponse === null) {
            return $this->getNewApiResponse();
        }

        return $this->apiResponse;
    }

    /**
     * @param ApiResponse $apiResponse
     * @return $this
     */
    public function setApiResponse(ApiResponse $apiResponse): ApiResponseBuilder {
        $this->apiResponse = $apiResponse;

        return $this;
    }

    /**
     * @return ApiResponseData
     */
    public function getApiResponseData(): ApiResponseData {
        if($this->apiResponse === null) {
            $this->getNewApiResponse();
        }

        return $this->apiResponse->getApiResponseData();
    }

    /**
     * @param ApiResponseData $apiResponseData
     * @return $this
     */
    public function setApiResponseData(ApiResponseData $apiResponseData): ApiResponseBuilder {
        $this->apiResponse->setApiResponseData($apiResponseData);

        return $this;
    }

    /**
     * @return ApiResponseMetadata
     */
    public function getApiResponseMetadata(): ApiResponseMetadata {
        if($this->apiResponse === null) {
            $this->getNewApiResponse();
        }

        return $this->getApiResponseData()->getResponseMetadata();
    }

    /**
     * @param ApiResponseMetadata $apiResponseMetadata
     * @return $this
     */
    public function setApiResponseMetadata(ApiResponseMetadata $apiResponseMetadata): ApiResponseBuilder {
        $this->apiResponse
            ->getApiResponseData()
            ->setResponseMetadata($apiResponseMetadata);

        return $this;
    }

    /**
     * @return ApiSettings
     */
    public function getApiSettings(): ApiSettings {
        if($this->apiResponse === null) {
            $this->getNewApiResponse();
        }

        return $this->getApiResponseMetadata()->getApiSettings();
    }

    /**
     * @param ApiSettings $apiSettings
     * @return $this
     */
    public function setApiSettings(ApiSettings $apiSettings): ApiResponseBuilder {
        $this->apiResponse
            ->getApiResponseData()
            ->getResponseMetadata()
            ->setApiSettings($apiSettings);

        return $this;
    }

    /**
     * @param bool $success
     * @return ApiResponseBuilder
     */
    public function setSuccess(bool $success): ApiResponseBuilder
    {
        $this->getApiResponseMetadata()->setSuccess($success);
        return $this;
    }

    /**
     * @param string $message
     * @return ApiResponseBuilder
     */
    public function setInfo(string $message): ApiResponseBuilder
    {
        $this->getApiResponseMetadata()->setInfoMessage($message);
        return $this;
    }

    /**
     * @param Exception $exception
     * @return ApiResponseBuilder
     */
    public function setErrorFromException(Exception $exception): ApiResponseBuilder
    {
        $this->setError($exception->getMessage(), ($exception->getCode() === 0 ? 500 : $exception->getCode()));
        return $this;
    }

    /**
     * @param string $errorMessage
     * @param int $errorCode
     * @return ApiResponseBuilder
     */
    public function setError(string $errorMessage = '', int $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR): ApiResponseBuilder
    {
        $this->setSuccess(false)
             ->setErrorMessage($errorMessage)
             ->setErrorCode($errorCode);

        return $this;
    }

    /**
     * @param int $errorCode
     * @return ApiResponseBuilder
     */
    public function setErrorCode(int $errorCode): ApiResponseBuilder
    {
        if(key_exists($errorCode, Response::$statusTexts)) {
            $this->getApiResponseData()->setResponseStatusCode($errorCode);
        }
        
        $this->getApiResponseMetadata()->setErrorCode($errorCode);
        return $this;
    }

    /**
     * @param string $errorMessage
     * @return ApiResponseBuilder
     */
    public function setErrorMessage(string $errorMessage): ApiResponseBuilder
    {
        $this->getApiResponseMetadata()->setErrorMessage($errorMessage);
        return $this;
    }

    /**
     * @param array|null $responseData
     * @param int $statusCode
     * @param array $headers
     * @return Response
     */
    public function returnApiResponse(?array $responseData = [], int $statusCode = Response::HTTP_OK, array $headers = []): Response {
        $this->getApiResponseData()->setResponseData($responseData);
        $this->getApiResponseData()->setResponseStatusCode($statusCode);

        $this->getApiResponse()->setCustomHeaders($headers);

        return $this->getResponse();
    }

    /**
     * @param Exception $exception
     * @param array|null $responseData
     * @param int $statusCode
     * @param array $headers
     * @return Response
     */
    public function returnException(Exception $exception, ?array $responseData = [], int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): Response {
        $this->setError($exception->getMessage(), ($exception->getCode() === 0 ? 500 : $exception->getCode()));
        $this->getApiResponseData()->setResponseData($responseData);
        $this->getApiResponseData()->setResponseStatusCode($statusCode);

        $this->getApiResponse()->setCustomHeaders($headers);

        return $this->getResponse();
    }
}
