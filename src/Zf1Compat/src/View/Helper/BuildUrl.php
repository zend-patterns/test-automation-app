<?php
namespace Zf1Compat\View\Helper;

/**
 * Helper that generates dynamic routes without the need of explicit route rules.
 */
class BuildUrl
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Generates a URL based on route params
     * @param array $params
     * @param string $routeName
     * @return string
     */
    public function __invoke(array $params, string $routeName = '')
    {
        if ($routeName == '') {
            $routeName = $params['module'] . '.' . $params['controller'];
        }
        return $this->router->url($routeName, $params);
    }
}
