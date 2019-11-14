<?php

namespace Slacker\models\db;

use PDO;

/**
 * Model for user functions in the DB
 */
class UserModel
{

    /**
     * Variable to hold database connection object
     *
     * @var PDO
     */
    private $db;

    /**
     * Initializes UserModel with PDO object
     *
     * @param PDO $db Database connection object
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Gets list of users from DB
     *
     * @return array Asscoc array of users unames
     */
    public function get_users() : array {
        $userListQuery = "SELECT `uname` FROM `users`";
        $query = $this->db->prepare($userListQuery);
        $query->execute();
        $userList = $query->fetchAll();
        return $userList;
    }

    /**
     * Adds a user to the DB 
     *
     * @param string $user Users username
     * @param string $hash Users password (prehashed)
     * @return boolean Returns true/false for DB query success
     */
    public function add_user(string $user, string $hash) : bool {

        $userCreateQuery = "INSERT INTO `users` (`uname`,`hash`) VALUES (:username, :passhash)";
        $query = $this->db->prepare($userCreateQuery);
        $query->bindParam(":username", $user, PDO::PARAM_STR);
        $query->bindParam(":passhash", $hash, PDO::PARAM_STR);
        $success = $query->execute();
        return $success;
    }

    /**
     * Gets a specificed users password hash from the DB
     *
     * @param string $user The username of the user
     * @return string The password hash for the specified user
     */
    public function get_user_pass_hash(string $user) : string {

        $userHashQuery = "SELECT `hash` FROM `users` WHERE `uname` = :user";
        $query = $this->db->prepare($userHashQuery);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $query->execute();
        $userHash = $query->fetch();
        return $userHash['hash'];
    }



}
