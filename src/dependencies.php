<?php

use Slim\App;
use PDO;

use Slacker\factories\models\db;
use Slacker\factories\models\db\UserModelFactory;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    /**
     * Creates a db object
     */
    $container['db'] = function ($c) : PDO {
        $db_settings = $c->get('settings')['DB_settings'];
        $db = new PDO($db_settings['dsn'], $db_settings['user'], $db_settings['password']);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    };

    // FACTORIES
    $container['UserModel'] = new UserModelFactory();

};
