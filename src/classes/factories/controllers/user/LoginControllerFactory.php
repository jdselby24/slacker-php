<?php

namespace Slacker\factories\controllers\user;

use Psr\Container\ContainerInterface;
use Slacker\controllers\user\LoginController;


/**
 * Factory for LoginController injecting User, Token and Message models
 */
class LoginControllerFactory
{
    public function __invoke(ContainerInterface $container) : LoginController
    {

        $userModel = $container->get('UserModel');
        $tokenModel = $container->get('TokenModel');
        $messageModel = $container->('MessageModel');

        return new LoginController($userModel, $tokenModel, $messageModel);
    }
}