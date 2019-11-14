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

    public function __invoke(Request $request, Response $response, array $args) : Response
    {

        $res = [
            'success' => false,
            'message' => 'data received'
        ];

        $req_data = $request->getParsedBody();
        if(isset($req_data['username']) && isset($req_data['password']) && isset($req_data['password2'])) {
            $username = $req_data['username'];
            $password1 = $req_data['password'];
            $password2 = $req_data['password2'];
        } else {
            return $response->withJson(['success' => false, 'message' => 'Incorrect data sent', 'data' => $request], 400);
        }

        if($this->UserModel->user_exists($username)) {
            return $response->withJson(['success' => false, 'message' => 'User already exists', 'data' => $request], 409);
        }

        if($password1 === $password2) {
            $passHash = password_hash($password1, PASSWORD_DEFAULT);
            $success = $this->UserModel->add_user($username, $passHash);  
        } else {
            return $response->withJson(['success' => false, 'message' => 'Passwords don\'t match', 'data' => $request], 200);
        }

        if($success === true) {
            return $response->withJson(['success' => true, 'message' => "User $username created", 'data' => $request], 200);
        } else {
            return $response->withJson(['success' => false, 'message' => "Error creating user", 'data' => $request], 500);
        }
    }
}

