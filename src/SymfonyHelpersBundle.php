<?php declare(strict_types=1);
namespace GWSN\Helpers;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymfonyHelpersBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
