<?php

use PDO;
include './Message.php';

class MessageMapper{
    private $db;
    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=testDB', 'sasha', 'rootroot');
    }
    
    public function searchAll(){
        $stmt = $this->db->query('SELECT * FROM messages');
        $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = array();
        foreach ($rows as $row){
            $Message = new Message($row['id'], $row['username'], $row['content']);
            array_push($result, $Message);
        }
        return $result;
    }
 
    public function insert($msg){
        $query = 'INSERT INTO messages (username, content) VALUES (:username, :content)';
        $stmt = $this->db->prepare($query);
        $params = [":username" => $msg->getUsername(), ':content' => $msg->getContent()];
        $stmt->execute($params);
    }

    public function delete($msg){
        $query = 'DELETE FROM messages WHERE username = :username AND content = :content';
        $stmt = $this->db->prepare($query);
	$params = [":username" => $msg->getUsername(), ':content' => $msg->getContent()];
        $stmt->execute($params);
    }
}
