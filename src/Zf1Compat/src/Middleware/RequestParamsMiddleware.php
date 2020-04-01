<?php

namespace Zf1Compat\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\Router\RouteResult;

class RequestParamsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);

        $getParams = $request->getQueryParams();
        $routeParams = $routeResult->getMatchedParams();
        $postParams = $request->getParsedBody();

        // Emulate ZF1 parameter fetching.
        $params = array_merge((array)$routeParams, (array)$getParams, (array)$postParams);
        $request = $request->withParsedBody($params);

        return $handler->handle($request);
    }
}
