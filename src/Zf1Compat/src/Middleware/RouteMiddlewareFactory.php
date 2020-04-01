<?php
namespace Zf1Compat\Middleware;

use Psr\Container\ContainerInterface;
use Mezzio\Router\RouterInterface;

class RouteMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        
        return new RouteMiddleware($router);
    }
}
