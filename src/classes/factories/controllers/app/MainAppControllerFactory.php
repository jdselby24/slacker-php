<?php

namespace Slacker\factories\controllers\app;

use Psr\Container\ContainerInterface;;
use Slacker\controllers\app\MainAppController;

class MainAppControllerFactory
{
    public function __invoke(ContainerInterface $container) : MainAppController
    {
        $renderer = $container->get('renderer');
        return new MainAppController($renderer);
    }
}