<?php declare(strict_types=1);
namespace GWSN\Helpers\Entity;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ApiSettings implements ContainerAwareInterface
{
    const CONFIG_KEY_APP_NAME = 'application_name';
    const CONFIG_KEY_APP_VERSION = 'application_version';
    const CONFIG_KEY_APP_AUTH_STRING = 'application_auth_string';

    const DEFAULT_APP_NAME = 'Symfony API';
    const DEFAULT_APP_VERSION = '1.0.0';
    const DEFAULT_APP_AUTH_STRING = 'basic_auth';

    private string $applicationName = self::DEFAULT_APP_NAME;
    private string $applicationVersion = self::DEFAULT_APP_VERSION;
    private string $applicationAuthString = self::DEFAULT_APP_AUTH_STRING;

    /** @var ContainerInterface */
    private ContainerInterface $container;

    public function __construct(?string $applicationName = null, ?string $applicationVersion = null, ?string $applicationAuthString = null) {

        if($applicationName !== null) {
            $this->setApplicationName($applicationName);
        }
        if($applicationVersion !== null) {
            $this->setApplicationVersion($applicationVersion);
        }
        if($applicationAuthString !== null) {
            $this->setApplicationAuthString($applicationAuthString);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setContainer(?ContainerInterface $container = null)
    {
        $this->container = $container;
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
    public function getApplicationAuthString(): string
    {
        return $this->applicationAuthString;
    }

    /**
     * @param string $applicationAuthString
     * @return ApiSettings
     */
    public function setApplicationAuthString(string $applicationAuthString): ApiSettings
    {
        $this->applicationAuthString = $applicationAuthString;
        return $this;
    }
}
