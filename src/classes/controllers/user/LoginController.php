<?php 

namespace Slacker\controllers\user;

use Slim\Http\Request;
use Slim\Http\Response;

use Slacker\models\db\UserModel;
use Slacker\models\db\TokenModel;
use Slacker\models\db\MessageModel;

class LoginController
{
    private $UserModel;
    private $TokenModel;
    private $MessageModel;

    public function __construct(UserModel $userModel, TokenModel $tokenModel, MessageModel $messageModel)
    {
        $this->UserModel = $userModel;
        $this->TokenModel = $tokenModel;
        $this->MessageModel = $messageModel;
    }

    public function __invoke(Request $request, Response $response, array $args) : Response
    {
        $req_data = $request->getParsedBody();

        if(isset($req_data['username']) && isset($req_data['password'])) {
            $username = $req_data['username'];
            $password = $req_data['password'];
            $passHash = $this->UserModel->get_user_pass_hash($username);
        } else {
            return $response->withJson(['success' => false, 'message' => 'Incorrect data sent', 'data' => $request], 400);
        }

        if(password_verify($password, $passHash)) {
            $token = $this->TokenModel->generate_login_token($username);
            $token_added = $this->TokenModel->set_token_inactive($username, $token);
        } else {
            return $response->withJson(['success' => false, 'message' => 'Incorrect password', 'data' => $request], 200);
        }

        if($token_added === true) {
            $this->MessageModel->add_msg('Slackerbot', "User $username logged in", 1);
            return $response->withJson(['success' => true, 'message' => 'Login Success', 'token'=>$token, 'data' => $request], 200);
        } else {
            return $response->withJson(['success' => false, 'message' => 'Internal Error: Could not log user in', 'data' => $request], 500);
        }
    }
}