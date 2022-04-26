<?php declare(strict_types=1);
namespace GWSN\Helpers\Entity;

class ApiResponseData
{
    /**
     * @var array|null
     */
    public array $responseData = [];
    /**
     * @var ApiResponseMetadata
     */
    public ApiResponseMetadata $responseMetadata;
    /**
     * @var int
     */
    public int $responseStatusCode;


    /**
     * @param array|null $responseData Give the response data as an Array
     * @param ApiResponseMetadata $responseMetadata
     * @param int $responseStatusCode
     */
    public function __construct(
        array               $responseData,
        ApiResponseMetadata $responseMetadata,
        int                 $responseStatusCode
    )
    {
        $this->responseData = $responseData;
        $this->responseMetadata = $responseMetadata;
        $this->responseStatusCode = $responseStatusCode;
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
     * @return ApiResponseData
     */
    public function setResponseData(array $responseData): ApiResponseData
    {
        $this->responseData = $responseData;
        return $this;
    }

    /**
     * @return ApiResponseMetadata
     */
    public function getResponseMetadata(): ApiResponseMetadata
    {
        return $this->responseMetadata;
    }

    /**
     * @param ApiResponseMetadata $responseMetadata
     * @return ApiResponseData
     */
    public function setResponseMetadata(ApiResponseMetadata $responseMetadata): ApiResponseData
    {
        $this->responseMetadata = $responseMetadata;
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
     * @return ApiResponseData
     */
    public function setResponseStatusCode(int $responseStatusCode): ApiResponseData
    {
        $this->responseStatusCode = $responseStatusCode;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array {
        return [
            'data' => $this->getResponseData(),
            'meta' => $this->getResponseMetadata()->toArray(),
            'status' => $this->getResponseStatusCode()
        ];
    }
}
