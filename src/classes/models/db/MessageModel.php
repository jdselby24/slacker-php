<?php

namespace Slacker\models\db;

use PDO;

class MessageModel
{

    /**
     * To hold the PDO injected from the construct
     *
     * @var PDO PDO Object
     */
    private $db;

    /**
     * Constructor injecting PDO object
     *
     * @param PDO $db PDO Object
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Method for adding a message to the DB
     *
     * @param string $user User who sent message
     * @param string $msg Message content
     * @param integer $channel Channel the message was sent to
     * @return boolean DB Success
     */
    function add_msg(string $user, string $msg, int $channel = 1) :bool {
        $msgAddQuery = "INSERT INTO `messages` (`channel_id`, `user`, `message`) VALUES (:channel, :user, :msg);";
        $query = $this->db->prepare($msgAddQuery);
        $query->bindParam(':channel', $channel, PDO::PARAM_INT);
        $query->bindValue(':user', $user, PDO::PARAM_STR);
        $query->bindParam(':msg', $msg, PDO::PARAM_STR);
        $state = $query->execute();
        return $state;
    }
    
    /**
     * Method for getting all messages in a channel from the DB
     *
     * @param string $channel Channel to get the messages from
     * @return array Assco array of all the messages
     */
    function get_msgs(string $channel) :array {
        $msgGetQuery = "SELECT `id`,`user`,`message` FROM `messages` WHERE `channel_id` = :channel;";
        $query = $this->db->prepare($msgGetQuery);
        $query->bindParam(':channel', $channel, PDO::PARAM_INT);
        $query->execute();
        $msgs = $query->fetchAll();
    
        return $msgs;
    }
}