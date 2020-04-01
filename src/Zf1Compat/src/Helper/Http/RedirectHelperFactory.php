<?php

namespace Zf1Compat\Helper\Http;

use Interop\Container\ContainerInterface;

class RedirectHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RedirectHelper($container);
    }
}
