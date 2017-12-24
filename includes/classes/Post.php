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

    public function loadPostsFriends($data, $limit){

        $page = $data['page'];
        $userLoggedIn = $this->user_obj->getUsername();

        if($page == 1)
            $start = 0;
        else
            $start = ($page - 1) * $limit;


        $str = '';//string to return

        $data = mysqli_query($this->con,"SELECT * FROM posts WHERE deleted = 'no' ORDER BY id DESC ");

        if(mysqli_num_rows($data) > 0) {

            $num_iterations = 0; //Number of results checked (not necasserily posted)
            $count = 1;

            while ($row = mysqli_fetch_object($data)) {
                $id = $row->id;
                $body = $row->body;
                $added_by = $row->added_by;
                $date_added = $row->date_added;

                //prepare user_to column from posts table
                if ($row->user_to == 'none') {
                    $user_to = '';
                } else {
                    //we are instancing an object from the User class for user_to(username) column,so we can use the methods from the User class
                    $user_to_object = new User($this->con, $row->user_to);
                    $user_full_name = $user_to_object->getFullName();
                    $user_to = " to <a href='{$row->user_to}'>$user_full_name</a>";
                }

                //Check if the user who posted has his account closed
                $added_by_obj = new User($this->con, $added_by);
                //if the user is closed we are breaking this iteration
                if ($added_by_obj->isClosed()) {
                    continue;
                }


                if($num_iterations++ < $start)
                    continue;


                //Once 10 posts have been loaded, break
                if($count > $limit) {
                    break;
                }
                else {
                    $count++;
                }





                //getting details for user who added the post from users table
                $user_details = mysqli_query($this->con, "SELECT first_name,last_name,profile_pic from users where username = '$added_by'");
                $user_row = mysqli_fetch_object($user_details);
                $first_name = $user_row->first_name;
                $last_name = $user_row->last_name;
                $profile_pic = $user_row->profile_pic;
                //Timeframe
                $time_elapsed = $this->time_elapsed_string($date_added);

                $str .= "<div class='status_post'>

                  <div class='post_profile_pic'>
                   <img src='$profile_pic' alt='' width='50' >
                  </div>
                  <div class='posted_by' style='color: #acacac'>
                    <a href='$added_by'>$first_name $last_name</a>$user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_elapsed
                    </div>
                    <div id='post_body'>
                       $body
                    </div>
                     <br>
        
                </div>
                <hr>
                ";


            }//End while loop

            if($count > $limit)
                $str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
            else
                $str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: center;'> No more posts to show! </p>";
        }

          echo $str;




    }

   //parsing date to show how much ago is the post
    public function time_elapsed_string($datetime, $full = false) {
        //current time
        $now = new DateTime;
        //the time of the post
        $ago = new DateTime($datetime);
        //difference between these two times
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}