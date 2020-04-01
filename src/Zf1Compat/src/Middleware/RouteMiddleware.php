<?php
namespace Zf1Compat\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\Router\Middleware\RouteMiddleware as ExpressiveRouteMiddleware;
use Mezzio\Router\Route;
use Mezzio\Router\RouteResult;

class RouteMiddleware extends ExpressiveRouteMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // if we have more than 3 URL segments then split the rest in pairs and use it as route params
        $originalRequest = $request;
        $uri = $request->getUri();
        $path = $uri->getPath();
        $path = trim($path, '/'); // remove leading and trailing slashes
        $path = preg_replace('/\/{2,}/', '/', $path); // replace two or more slashes with one
        $parts = explode('/', $path);
        $routeParams = [];

        $newPath = false;
        if (count($parts) > 3) {
            $leadingPath = sprintf('/%s/%s/%s', $parts[0], $parts[1], $parts[2]);

            for ($i=3; $i<count($parts); $i=$i+2) {
                $routeParams[$parts[$i]] = '';
                if (isset($parts[$i+1])) {
                    $routeParams[$parts[$i]] = urldecode($parts[$i+1]);
                }
            }

            $newPath = $leadingPath;
        } elseif ($originalRequest->getUri()->getPath() != '/'.$path) {
            $newPath = '/'.$path;
        }

        if ($newPath !== false) {
            $uri = $uri->withPath($newPath);
            $request = $request->withUri($uri);
        }

        $result = $this->router->match($request);
        if ($result->getMatchedRoute()) {
            $routeParams = array_merge($routeParams, $result->getMatchedParams());
            $result = RouteResult::fromRoute($result->getMatchedRoute(), $routeParams);
        } else {
            // as a fallback try the original path
            $request = $originalRequest;
            $result = $this->router->match($request);
        }

        // Inject the actual route result, as well as individual matched parameters.
        $request = $request->withAttribute(RouteResult::class, $result);

        if ($result->isSuccess()) {
            $route = $result->getMatchedRoute();
            if ($route instanceof Route) {
                $defaults = $route->getOptions();
                $routeParams = array_merge($defaults, $routeParams);
                $result = RouteResult::fromRoute($route, $routeParams);
                $request = $request->withAttribute(RouteResult::class, $result);
            }

            foreach ($result->getMatchedParams() as $param => $value) {
                $request = $request->withAttribute($param, $value);
            }
        }

        return $handler->handle($request);
    }
}
