<?php

declare(strict_types=1);

namespace Zf1Compat;

use Laminas\Navigation\View\ViewHelperManagerDelegatorFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\View\HelperPluginManager;
use Laminas\View\Renderer\PhpRenderer;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'view_helpers' => $this->getViewHelpers(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                PhpRenderer::class => InvokableFactory::class,
                View\View::class => View\ViewFactory::class,

                // Helpers
                Helper\Http\RedirectHelper::class => Helper\Http\RedirectHelperFactory::class,

                // middleware
                Middleware\RequestParamsMiddleware::class => InvokableFactory::class,
                Middleware\RouteMiddleware::class => Middleware\RouteMiddlewareFactory::class,

            ],
            'delegators' => [
                HelperPluginManager::class => [
                    ViewHelperManagerDelegatorFactory::class,
                ],
            ],
            'aliases' => [
                'ViewHelperManager' => HelperPluginManager::class,
                'Zf1CompatView' => View\View::class,
            ]
        ];
    }

    /**
     * Returns the registered view helpers
     */
    public function getViewHelpers() : array
    {
        return [
            'factories'  => [
                View\Helper\BaseUrl::class => InvokableFactory::class,
                View\Helper\FormCheckbox::class => InvokableFactory::class,
                View\Helper\FormHidden::class => InvokableFactory::class,
                View\Helper\FormRadio::class => InvokableFactory::class,
                View\Helper\FormSelect::class => View\Helper\FormSelectFactory::class,
                View\Helper\FormText::class => InvokableFactory::class,
                View\Helper\Partial::class => View\Helper\PartialFactory::class,
                View\Helper\Router::class => InvokableFactory::class,
                View\Helper\BuildUrl::class => View\Helper\BuildUrlFactory::class,
            ],
            'aliases' => [
                'baseUrl'   => View\Helper\BaseUrl::class,
                'formCheckbox'=> View\Helper\FormCheckbox::class,
                'formHidden' => View\Helper\FormHidden::class,
                'formRadio' => View\Helper\FormRadio::class,
                'formSelect'=> View\Helper\FormSelect::class,
                'formText'=> View\Helper\FormText::class,
                'partial' => View\Helper\Partial::class,
                'Partial' => View\Helper\Partial::class,
                'router'  => View\Helper\Router::class,
                'buildUrl'     => View\Helper\BuildUrl::class,
            ]
        ];
    }
}
