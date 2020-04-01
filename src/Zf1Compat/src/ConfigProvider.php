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
                View\Helper\FormCheckbox::class => InvokableFactory::class,
            ],
            'aliases' => [
                'formCheckbox'=> View\Helper\FormCheckbox::class,
            ]
        ];
    }
}
