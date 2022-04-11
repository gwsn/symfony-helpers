<?php declare(strict_types=1);
namespace GWSN\Helpers\DependencyInjection;

use GWSN\Helpers\Entity\ApiSettings;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SymfonyHelpersExtension::CONFIG_KEY);
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->scalarNode(ApiSettings::CONFIG_KEY_APP_NAME)
                ->defaultValue(ApiSettings::DEFAULT_APP_NAME)
                ->info('This value will be visible in the apiResponse meta section')
            ->end()
            ->scalarNode(ApiSettings::CONFIG_KEY_APP_VERSION)
                ->defaultValue(ApiSettings::DEFAULT_APP_VERSION)
                ->info('This value will be visible in the apiResponse meta section')
            ->end()
            ->scalarNode(ApiSettings::CONFIG_KEY_APP_AUTH_STRING)
                ->defaultValue(ApiSettings::DEFAULT_APP_AUTH_STRING)
                ->info('This value will be visible in the apiResponse meta section')
            ->end()
        ->end();
        return $treeBuilder;
    }
}
