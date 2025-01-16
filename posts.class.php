<?php
class Post{
    private $id;
    private $user_id;  
    private $title;
    private $body;
    private $image_data;
    private $created_at;    
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setBody($body){
        $this->body = $body;
    }

    public function setImageData($image_data){
        $this->image_data = $image_data;
    }

    public function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }

    public function getId(){
        return $this->id;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getBody(){
        return $this->body;
    }

    public function getImageData(){
        return $this->image_data;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

    public function save(){
        require 'database.php';
        $stmt = $db->prepare("INSERT INTO posts (user_id, title, body, image_data) VALUES (:user_id, :title, :body, :image_data)");
        $stmt->execute([
            'user_id' => $this->getUserId(),
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'image_data' => $this->getImageData(),
        ]);
    }

    public function delete(){
        require 'database.php';
        $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->execute(['id' => $this->getId()]);
    }
}