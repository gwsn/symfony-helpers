<?php declare(strict_types=1);
namespace GWSN\Helpers\Controller;

use Exception;
use GWSN\Helpers\Entity\ApiSettings;
use GWSN\Helpers\Services\Response\ApiResponseBuilder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
abstract class AbstractApiController extends AbstractController
{

    /**  @var ApiResponseBuilder|null $arb Api Response Builder */
    private ?ApiResponseBuilder $arb = null;

    public function buildResponse() {
        $this->setArb(new ApiResponseBuilder);
        $this->arb->setApiSettings($this->getApiSettings());
    }

    /**
     * @return ApiResponseBuilder|null
     */
    public function getArb(): ?ApiResponseBuilder
    {
        return $this->arb;
    }

    /**
     * @param ApiResponseBuilder|null $arb
     * @return AbstractApiController
     */
    public function setArb(?ApiResponseBuilder $arb): AbstractApiController
    {
        $this->arb = $arb;
        return $this;
    }    
    
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'api_settings' => '?'.ApiSettings::class,
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
     * @param array|null $responseData
     * @param int $statusCode
     * @return Response
     */
    public function returnApiResponse(?array $responseData = [], int $statusCode = Response::HTTP_OK, array $headers = []): Response {
        $this->buildResponse();

        return $this->arb->returnApiResponse($responseData, $statusCode, $headers);
    }

    /**
     * @param Exception $exception
     * @param int $statusCode
     * @return Response
     */
    public function returnException(Exception $exception, ?array $responseData = [],  int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): Response {
        $this->buildResponse();

        return $this->arb->returnException($exception, $responseData, $statusCode, $headers);
    }
}
