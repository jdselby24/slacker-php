<?php

namespace Slacker\factories\models\db;

use Psr\Container\ContainerInterface;
use Slacker\models\db\UserModel;

/**
 * Factory for UserModel, injecting a PDO object
 */
class UserModelFactory 
{
    function __invoke(ContainerInterface $container)
    {
        $db = $container->get('db');
        return new UserModel($db);
    }
}