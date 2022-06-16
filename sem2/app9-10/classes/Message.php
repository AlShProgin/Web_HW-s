<?php
class Message{
    private $id;
    private $username;
    private $content;
    
    public function __construct($i, $u, $c) {
        $this->id=$i;
        $this->username=$u;
        $this->content=$c;
    }

    public function getContent() { return $this->content; }

    public function setContent($input) { $this->content = $input; }

    public function getUsername() { return $this->username; }

    public function setUsername($input) { $this->username = $input; }

    public function getId() { return $this->id; }
}
