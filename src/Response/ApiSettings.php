<?php declare(strict_types=1);
namespace GWSN\Helpers\Response;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ApiSettings
{
    const APP_NAME = 'APP_NAME';
    const APP_VERSION = 'application_version';
    const API_VERSION = 'API_VERSION';

    private string $applicationName;
    private string $applicationVersion;
    private string $applicationAuthVersion;


    public function __construct(?ContainerBagInterface $params = null) {
        $this->applicationName = 'Symfony API';
        $this->applicationVersion = '1.0.0';
        $this->applicationAuthVersion = 'v1';

        if($params !== null) {
            if($params->has(self::APP_NAME)) {
                $this->setApplicationName($params->get(self::APP_NAME));
            }
            if($params->has(self::APP_VERSION)) {
                $this->setApplicationVersion($params->get(self::APP_VERSION));
            }
            if($params->has(self::API_VERSION)) {
                $this->setApplicationAuthVersion($params->get(self::API_VERSION));
            }
        }
    }

    /**
     * @return string
     */
    public function getApplicationName(): string
    {
        return $this->applicationName;
    }

    /**
     * @param string $applicationName
     * @return ApiSettings
     */
    public function setApplicationName(string $applicationName): ApiSettings
    {
        $this->applicationName = $applicationName;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationVersion(): string
    {
        return $this->applicationVersion;
    }

    /**
     * @param string $applicationVersion
     * @return ApiSettings
     */
    public function setApplicationVersion(string $applicationVersion): ApiSettings
    {
        $this->applicationVersion = $applicationVersion;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationAuthVersion(): string
    {
        return $this->applicationAuthVersion;
    }

    /**
     * @param string $applicationAuthVersion
     * @return ApiSettings
     */
    public function setApplicationAuthVersion(string $applicationAuthVersion): ApiSettings
    {
        $this->applicationAuthVersion = $applicationAuthVersion;
        return $this;
    }
}
