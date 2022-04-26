<?php declare(strict_types=1);
namespace GWSN\Helpers\DependencyInjection;

use Exception;
use GWSN\Helpers\Entity\ApiSettings;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SymfonyHelpersExtension extends Extension
{
    public const CONFIG_KEY = 'symfony_helpers';

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('symfony_helpers.api_settings');
        $definition->setArgument(0, $config[ApiSettings::CONFIG_KEY_APP_NAME]);
        $definition->setArgument(1, $config[ApiSettings::CONFIG_KEY_APP_VERSION]);
        $definition->setArgument(2, $config[ApiSettings::CONFIG_KEY_APP_AUTH_STRING]);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return self::CONFIG_KEY;
    }
}
