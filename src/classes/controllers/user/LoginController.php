<?php 

namespace Slacker\controllers\user;

use Slim\Http\Request;
use Slim\Http\Response;

use Slacker\models\db\UserModel;
use Slacker\models\db\TokenModel;

class LoginController
{
    private $UserModel;
    private $TokenModel;

    public function __construct(UserModel $userModel, TokenModel $tokenModel)
    {
        $this->UserModel = $userModel;
        $this->TokenModel = $tokenModel;
    }

    public function __invoke(Request $request, Response $response, array $args) : Response
    {
        $res = [
            'success' => false,
            'message' => 'data received'
        ];

        $req_data = $request->getParsedBody();

        if(isset($req_data['username']) && isset($req_data['password'])) {
            $username = $req_data['username'];
            $password = $req_data['password'];
            $passHash = $this->UserModel->get_user_pass_hash($username);
        } else {
            return $response->withJson(['success' => false, 'message' => 'Incorrect data sent', 'data' => $request], 400);
        }

        if(password_verify($password, $passHash)) {
            // TODO: Finish transfering functionality, add message functions to a MessageModel class
        }


    }
}