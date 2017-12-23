<?php

class Post {

    private $user_obj;
    private $con;


    public function __construct($con,$user){
        $this->con = $con;
        $this->user_obj = new User($con,$user);
    }

    public function submitPost($body,$user_to){
        $body = strip_tags($body);//remove html tags
        $body = trim($body);
        $body = mysqli_real_escape_string($this->con,$body);
        if($body !=''){
            //current date and time
            $date_added = date("d-m-Y H:i:s");
            //Get username
            $added_by =  $this->user_obj->getUsername();
            if($user_to == $added_by){
               $user_to = 'none';
            }

            //insert post
            $query = mysqli_query($this->con,"INSERT into posts(body,added_by,user_to,date_added,user_closed,deleted,likes) VALUES('$body','$added_by','$user_to','$date_added','no','no',0)");
            $returned_id =  mysqli_insert_id($this->con);

            //Insert notification

            //Update post count for user
            $num_posts =  $this->user_obj->getNumberOfPosts();
            $num_posts++;
            $update_query_num_posts = mysqli_query($this->con,"UPDATE users SET num_posts = '$num_posts' WHERE username = '$added_by' ");



        }
    }

}