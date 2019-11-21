<?php

namespace Slacker\factories\controllers\user;

use Psr\Container\ContainerInterface;
use Slacker\controllers\user\AddUserController;

/**
 * Factory for AddUserController, injecting User and Token models
 */
class AddUserControllerFactory
{

    public function __invoke(ContainerInterface $container) : AddUserController
    {
        $userModel = $container->get('UserModel');
        $tokenModel = $container->get('TokenModel');

        return new AddUserController($userModel, $tokenModel);
    }

}