<?php
use PDO;

class User{
    public $db;
    
    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=testDB', 'sasha', 'rootroot');
    }
    
    public function searchAll(){   
        $result = $this->db->query('SELECT * FROM users');
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    public function searchAttr($attr, $attrName = "username"){
        $stmt="";
        switch ($attrName) {
            case "username":
                $query = "SELECT * FROM users WHERE username = :name";
                $params = [":name" => $attr];
                $stmt = $this->db->prepare($query);
                $stmt->execute($params);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $rows[0];
                break;
            case "password":
                $query = "SELECT * FROM users WHERE password = :password";
                $params = [":password" => $attr];
                $stmt = $this->db->prepare($query);
                $stmt->execute($params);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $rows;
                break;
            default:
                #echo "<br>Invalid attribute";
                return null;
        }   
    }
    public function isReal($name, $password){
        $candidate = $this->searchAttr($name, "username");
        if(is_null($candidate)) {
            echo "<br>Incorrect Username";
            return false;
        }
        else {
            if($candidate['password'] == $password) {
                return true;
            }
            else {
                echo "Incorrect password";
                return false;
            }
        }
    }
    public function insert($name, $password){
        if($name == "" || $password == ""){
            echo "<br>username or password not provided";
            return false;
        }
    	$rows = $this->searchAttr('username', $name);
    	if(count($rows) > 0) {
    	    echo "<br>User with this name already exists";
    	    return false;
    	}
        echo "<br>starting insertion";
        $query = "INSERT INTO users (username, password) VALUES (:name, :password)";
        $params = [":name" => $name, ":password" => $password];
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
	return true;
    }
    public function delete($name){
    	$rows = $this->searchAttr('username', $name);
    	if(count($rows) == 0) {
    	    return false;
    	}
        echo "<br>starting deletion<br>";
        $query = "DELETE FROM users WHERE username = :name";
        $params = [":name" => $name];
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
	return true;
    }
    public function update($attrName, $name, $attr_old, $attr_new){
        $rows = $this->searchAttr('username', $name);
    	if(count($rows) == 0) {
    	    echo "<br>No such user exists";
    	    return false;
    	}
        $stmt="";
        switch ($attrName) {
            case "username":
                $query = "UPDATE users SET username = :attr_new WHERE username = :attr_old";
                $params = [":attr_old" => $attr_old,
                           ":attr_new" => $attr_new];
                $stmt = $this->db->prepare($query);
                $stmt->execute($params);
                return true;
            case "password":
                $query = "UPDATE users SET password = :attr_new WHERE password = :attr_old";
                $params = [":attr_old" => $attr_old,
                           ":attr_new" => $attr_new];
                $stmt = $this->db->prepare($query);
                $stmt->execute($params);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $true;
            default:
                echo "<br>Invalid attribute";
        }   
    }

    public function info(){
        echo "<br>Received an object of Users<br>";
    }
}
