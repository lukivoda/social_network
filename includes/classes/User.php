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

    public function isClosed(){
        $username = $this->getUsername();
        $user_closed_query = mysqli_query($this->con,"SELECT user_closed from users WHERE username = '$username'  ");
        $row = mysqli_fetch_object($user_closed_query);
        $user_closed = $row->user_closed;
        if($user_closed == 'yes'){
            return true;
        }else{
            return false;
        }

    }

    public function getNumberOfPosts(){
        return $this->user->num_posts;
    }


    //Checking if the user who posted the post is our friend or we are the authors of the post
    public function isFriend($username_to_check) {

        $usernameComma = ",".$username_to_check.",";

        if(strstr($this->user->friends_array,$usernameComma) ||$this->user->username== $username_to_check){
           return true;
        }else {
            return false;
        }

    }
}