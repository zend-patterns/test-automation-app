<?php
namespace Zf1Compat\View\Helper;

use Psr\Container\ContainerInterface;
use Zf1Compat\View\View;

class PartialFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $view = $container->get(View::class);

        return new Partial($view);
    }
}
