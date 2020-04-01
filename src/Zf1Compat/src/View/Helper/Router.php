<?php
namespace Zf1Compat\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * Route helper that mimics the behaviour of Zend_Controller_Action_Helper_Url
 */
class Router extends AbstractHelper
{
    private static $standardParams = ['module', 'controller', 'action'];

    public function __invoke()
    {
        return $this;
    }

    public function url($routeName, $routeParams)
    {
        $path = $this->view->url($routeName, $routeParams);
        foreach (self::$standardParams as $param) {
            unset($routeParams[$param]);
        }

        foreach ($routeParams as $key=>$value) {
            $path .= sprintf("/%s/%s", urlencode($key), urlencode($value));
        }

        return $path;
    }
}
