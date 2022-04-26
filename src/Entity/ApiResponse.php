<?php declare(strict_types=1);
namespace GWSN\Helpers\Entity;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse extends JsonResponse
{
    private ApiResponseData $apiResponseData;
    private ?array $customHeaders;

    /**
     * @param ApiResponseData $apiResponseData
     * @param array|null $headers
     */
    public function __construct(
        ApiResponseData $apiResponseData,
        ?array $headers = null
    )
    {
        $this->apiResponseData = $apiResponseData;
        $this->customHeaders = $headers;

        return $this->getResponse();
    }

    /**
     * @return ApiResponseData
     */
    public function getApiResponseData(): ApiResponseData
    {
        return $this->apiResponseData;
    }

    /**
     * @param ApiResponseData $apiResponseData
     * @return ApiResponse
     */
    public function setApiResponseData(ApiResponseData $apiResponseData): ApiResponse
    {
        $this->apiResponseData = $apiResponseData;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCustomHeaders(): ?array
    {
        return $this->customHeaders;
    }

    /**
     * @param array $customHeaders
     * @return ApiResponse
     */
    public function setCustomHeaders(array $customHeaders): ApiResponse
    {
        if(!is_array($this->customHeaders)) {
            $this->customHeaders = $customHeaders;
            return $this;
        }

        $this->customHeaders = array_merge($this->customHeaders, $customHeaders);

        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response {
        $apiResponseData = $this->getApiResponseData();
        $responseData = $apiResponseData->getResponseData();

        if( $apiResponseData->getResponseMetadata()->getTotal() === null &&
            !array_key_exists('uuid', $responseData) &&
            !array_key_exists('id', $responseData)
        ) {
            $apiResponseData->getResponseMetadata()->setTotal(is_array($responseData) ? count($responseData) : 0);
        }

        return new JsonResponse(
            $apiResponseData->toArray(),
            $apiResponseData->getResponseStatusCode(),
            ($this->customHeaders ?? []),
            false
        );
    }
}
