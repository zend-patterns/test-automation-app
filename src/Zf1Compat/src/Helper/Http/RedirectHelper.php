<?php

namespace Zf1Compat\Helper\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response;

class RedirectHelper
{
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function redirect($routeParams, array $extraParams = array())
    {
        $url = '/'.$routeParams['module'].'/'.$routeParams['controller'].'/'.$routeParams['action'];

        foreach ($extraParams as $key=>$value) {
            $url .= sprintf('/%s/%s', $key, $value);
        }
        
        $response = new Response();
        $response = $response->withHeader('Location', $url);
        $response = $response->withStatus(302);
        
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param $handlerKey Fully-qualified class name of a handler or the key used in the handler registration
     * @return mixed
     */
    public function redirectInternal(ServerRequestInterface $request, $handlerKey)
    {
        $params = $request->getParsedBody();
        $handlerName = sprintf(
            $handlerKey,
            ucfirst($params['module']),
            ucfirst($params['controller'])
        );

        /** @var RequestHandlerInterface $handler */
        $handler = $this->container->get($handlerName);

        return $handler->handle($request);
    }
    
    /**
     * Set a redirect URL of the form /module/controller/action/params
     *
     * @param  string $action
     * @param  string $controller
     * @param  string $module
     * @param  array  $extraParams
     */
    public function setGotoSimple(ServerRequestInterface $request, $action, $controller = null, $module = null, array $extraParams = array()): Response
    {
        $routeParams = $request->getParsedBody();

        $routeParams['action'] = $action;
        
        if ($controller) {
            $routeParams['controller'] = $controller;
        }
        
        if ($module) {
            $routeParams['module']     = $module;
        }

        return $this->redirect($routeParams, $extraParams);
    }
}
