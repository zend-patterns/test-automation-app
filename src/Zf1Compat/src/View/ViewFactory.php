<?php
namespace Zf1Compat\View;

use Psr\Container\ContainerInterface;
use Mezzio\Template\TemplateRendererInterface;

class ViewFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $template = $container->get(TemplateRendererInterface::class);
        $helpers = $container->get('ViewHelperManager');

        return new View($template, $helpers);
    }
}
