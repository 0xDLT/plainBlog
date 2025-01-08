<?php
class User {
    private $username;
    private $password;  
    private $avatar;

    public function __construct($username, $password) {
        $this->username = $username;
        if ($password !== null) {
            $this->password = $password;  
        }
    }

    // Getter and Setter for username
    public function getUsername(){
        return $this->username;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    // Getter and Setter for avatar
    public function getAvatar(){
        return $this->avatar;
    }

    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }

    // Getter for password (for internal use only)
    public function getPassword(){
        return $this->password;
    }

    public function setPasswordHash($password){
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword($storedPassword) {
        return password_verify($this->password, $storedPassword);  // Compare plaintext password with stored hashed password
    }
}
