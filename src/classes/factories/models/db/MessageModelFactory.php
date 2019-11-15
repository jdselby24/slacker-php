<?php

namespace Slacker\factories\models\db;

use Psr\Container\ContainerInterface;
use Slacker\models\db\MessageModel;

/**
 * Factory for MessageModel, injecting a PDO object
 */
class TokenModelFactory 
{
    function __invoke(ContainerInterface $container) : MessageModel
    {
        $db = $container->get('db');
        return new MessageModel($db);
    }
}