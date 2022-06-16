<?php

include './Message.php';
include './MessageMapper.php';

class MessageRepository{

    private $messages;
    private $mapper;

    public function __construct() {
        $this->mapper = new MessageMapper();
        $this->messages = $this->mapper->searchAll();
    }

    public function searchAll() {
        return $this->messages;
    }
    
    public function searchId($Id) {
        foreach ($this->messages as $message){
            if($message->getId()==$Id){
                return $message;
            }
        }
        return null;
    }
    
    public function searchUsername($username){
        $result = array();
        foreach ($this->messages as $message){
            if($message->getUsername() == $username){
                array_push($result, $message);
            }
        }
        return  $result;
    }
    
    public function searchAttr($attr, $attrName = 'username'){
        switch ($attrName) {
            case 'id':
                $result = $this->searchId($attr);
                return $result;
                break;
            case 'username':
                $result = $this->searchUsername($attr);
                return $result;
                break;
            default:
                echo "<br>Repository->searchArr: Invalid data type";
                return null;
        }
    }
    
    public function insert($msg){
        $this->mapper->insert($msg);
        $new_msg = new Message($msg->id, $msg->username, $msg->content);
        array_push($this->messages, $new_msg);
    }
    
    public function deleteForUsername($username){
        foreach ($this->messages as $message){
            if($message->getUsername() == $username){
                $this->mapper->delete($message);
            }
        }
        $this->messages = $this->mapper->searchAll();
    }  
}
