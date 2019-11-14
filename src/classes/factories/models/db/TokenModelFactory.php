<?php

namespace Slacker\factories\models\db;

use Psr\Container\ContainerInterface;
use Slacker\models\db\TokenModel;

/**
 * Factory for UserModel, injecting a PDO object
 */
class TokenModelFactory 
{
    function __invoke(ContainerInterface $container) : TokenModel
    {
        $db = $container->get('db');
        return new TokenModel($db);
    }
}