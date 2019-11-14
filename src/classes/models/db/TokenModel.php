<?php

namespace Slacker\models\db;

use PDO;

/**
 * Class for token based interaction
 */
class TokenModel
{

    /**
     * Database object
     *
     * @var PDO
     */
    private $db;

    /**
     * Constructor for injecting PDO object
     *
     * @param PDO $db Database object
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    
    /**
     * For generating a new login token
     *
     * @param string $user Username to generate token for 
     * @return string Random MD5 hash based on usename, timestamp and a random number
     */
    public function generate_login_token(string $user) : string {
        $string = $user . time() . rand();
        $token = md5($string, false);
        return $token;
    }
    
    /**
     * Adds a users token to the database
     *
     * @param string $user Users username
     * @param string $token Users current token
     * @return boolean DB Success
     */
    public function set_token_active(string $user,string $token) : bool {

        $tokenAddQuery = "INSERT INTO `users_active` (`uname`,`token`) VALUES (:user, :token)";
        $query = $this->db->prepare($tokenAddQuery);
        $query->bindParam(":user", $user, PDO::PARAM_STR);
        $query->bindParam(":token", $token, PDO::PARAM_STR);
        $success = $query->execute();
        return $success;
    }

    /**
     * Set a users past token to inactive
     *
     * @param string $user Users username
     * @param string $token Users current token
     * @return boolean DB Success
     */
    public function set_token_inactive(string $user, string $token) : bool {

        $tokenInactiveQuery = "UPDATE `users_active` SET `ended` = '1', `time_out` = :timeval WHERE `uname` = :user AND `token` = :token";
        $query = $this->db->prepare($tokenInactiveQuery);
        $query->bindParam(':timeval', date('Y-n-d H:i:s'), PDO::PARAM_STR);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $query->bindParam(':token', $token, PDO::PARAM_STR);
        $success = $query->execute();
        return $success;
    }

    /**
     * Sets all a users tokens to inactive
     *
     * @param string $user Users username
     * @return boolean DB Success
     */
    public function set_token_inactive_all(string $user) : bool {

        $tokenInactiveQuery = "UPDATE `users_active` SET `ended` = '1', `time_out` = :timeval WHERE `uname` = :user;";
        $query = $this->db->prepare($tokenInactiveQuery);
        $query->bindParam(':timeval', date('Y-n-d H:i:s'), PDO::PARAM_STR);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $success = $query->execute();
        return $success;
    }

    /**
     * Get a users current token
     *
     * @param string $user Users username
     * @return string DB Success
     */
    public function get_current_token(string $user) : string {

        $tokenQuery = "SELECT `token` FROM `users_active` WHERE NOT `ended` = '1' AND `uname` = :user";
        $query = $this->db->prepare($tokenQuery);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $query->execute();
        $token = $query->fetch()['token'];
        return $token;
    }
    
    /**
     * For updating a users token in the DB
     *
     * @param string $oldToken Users current token
     * @param string $newToken Newly generated tokeb
     * @return boolean DB Success
     */
    public function update_token(string $oldToken, string $newToken) : bool {
        $updateTokenQuery = "UPDATE `users_active` SET `token` = :newtoken WHERE `token` = :oldtoken AND NOT `ended` = '1';";
        $query = $this->db->prepare($updateTokenQuery);
        $query->bindParam(':oldtoken', $oldToken, PDO::PARAM_STR);
        $query->bindParam(':newtoken', $newToken, PDO::PARAM_STR);
        $state = $query->execute();
        return $state;
    }

    /**
     * Get all token data
     *
     * @param string $token 
     * @return array Token data
     */
    public function get_token_data(string $token) : array {
    
        $tokenQuery = "SELECT * FROM `users_active` WHERE `token` = :token";
        $query = $this->db->prepare($tokenQuery);
        $query->bindParam(':token', $token, PDO::PARAM_STR);
        $query->execute();
        $token = $query->fetch();
    
        if($token === false) {
            $token = [];
        }
        return $token;
    }
}