<?php
namespace Zf1Compat\View\Helper;

use Psr\Container\ContainerInterface;

class FormSelectFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get("config");
        if (isset($config["view_helper_config"]['formSelect'])) {
            $config =  $config["view_helper_config"]['formSelect'];
        } else {
            $config = [];
        }

        return new FormSelect($config);
    }
}
