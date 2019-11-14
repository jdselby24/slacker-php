<?php

namespace Slacker\controllers\user;

use Slim\Http\Request;
use Slim\Http\Response;

use Slacker\models\db\UserModel;
use Slacker\models\db\TokenModel;

class AddUserController
{
    private $UserModel;
    private $TokenModel;

    public function __construct(UserModel $UserModel, TokenModel $TokenModel)
    {
        $this->UserModel = $UserModel;
        $this->TokenModel = $TokenModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        // TODO: Copy functionality from old slacker
    }
}

