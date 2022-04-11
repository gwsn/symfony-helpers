<?php declare(strict_types=1);
namespace GWSN\Helpers;

use GWSN\Helpers\DependencyInjection\SymfonyHelpersExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymfonyHelpersBundle extends Bundle
{
    /**
     * @return string
     */
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    /**
     * @return ExtensionInterface|null
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if($this->extension === null) {
            $this->extension = new SymfonyHelpersExtension;
        }

        return $this->extension;
    }


}
