<?php declare(strict_types=1);
namespace GWSN\Helpers\Controller;

use Exception;
use GWSN\Helpers\Entity\ApiSettings;
use GWSN\Helpers\Entity\ResponseMetadata;
use GWSN\Helpers\Services\Response\ApiResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
abstract class AbstractApiController extends AbstractController
{

    /**  @var ApiResponse|null $apiResponse */
    private ?ApiResponse $apiResponse = null;

    /**  @var ResponseMetadata|null $responseMetadata */
    private ?ResponseMetadata $responseMetadata = null;

    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            // ...
            'api_settings' => ApiSettings::class,
        ]);
    }

    /**
     * @return ApiSettings
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getApiSettings(): ApiSettings {

        if ($this->container === null || !$this->container->has('api_settings')) {
            return new ApiSettings;
        }

        return $this->container->get('api_settings');
    }

    /**
     * @return ApiResponse
     */
    public function getApiResponse(): ApiResponse {
        if($this->apiResponse === null) {
            $this->apiResponse = new ApiResponse;
        }
        $this->apiResponse->setResponseMetadata($this->getResponseMetadata());

        return $this->apiResponse;
    }

    /**
     * @return ResponseMetadata
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getResponseMetadata(): ResponseMetadata {
        if($this->responseMetadata === null) {
            $this->responseMetadata = new ResponseMetadata($this->getApiSettings());
        }
        return $this->responseMetadata;
    }

    /**
     * @param array|null $responseData
     * @param int $statusCode
     * @return Response
     */
    public function returnApiResponse(?array $responseData = [], int $statusCode = Response::HTTP_OK): Response {
        return $this->getApiResponse()
            ->setResponseData($responseData)
            ->setResponseStatusCode($statusCode)
            ->getResponse();
    }

    /**
     * @param Exception $exception
     * @param int $statusCode
     * @return Response
     */
    public function returnException(Exception $exception, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): Response {
        return $this->getApiResponse()
            ->setErrorFromException($exception)
            ->setResponseStatusCode($statusCode)
            ->getResponse();
    }
}
