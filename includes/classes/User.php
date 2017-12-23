<?php

class User {

    private $user;
    private $con;
    public $first_name;
    public $last_name;

    public function __construct($con,$user){
        $this->con = $con;
        $user_details_query = mysqli_query($con,"SELECT * FROM users WHERE username = '$user'");
       $this->user = mysqli_fetch_object($user_details_query);
    }

    public function getFullName() {
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $name  = $this->first_name." ".$this->last_name;
        return $name;

    }

    public function getUsername(){
        return $this->user->username;
    }

    public function getNumberOfPosts(){
        return $this->user->num_posts;
    }
}