<?php
namespace Zf1Compat\View\Helper;

use Psr\Container\ContainerInterface;
use Laminas\View\HelperPluginManager;

class BuildUrlFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $viewHelperManager = $container->get(HelperPluginManager::class);
        $router = $viewHelperManager->get(Router::class);

        return new BuildUrl($router);
    }
}
