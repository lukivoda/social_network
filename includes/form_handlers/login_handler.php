<?php
if(isset($_POST["btn_login"])) {
    $email = $_POST["log_email"];
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);//sanitizing(removing not needed characters)
    $_SESSION['email'] = $email;

    $password = $_POST["log_password"];
    $password = md5($password);

    $user_exists_query =  mysqli_query($con,"SELECT * FROM users WHERE email = '$email' and password ='$password' ");


    $user_row_count = mysqli_num_rows($user_exists_query);

    //checking if we have only one match
    if($user_row_count == 1){
        $row = mysqli_fetch_assoc($user_exists_query);
        $username = $row['username'];
        $_SESSION['username'] = $username;
        //query for searching user with closed account
        $select_user_closed_query = mysqli_query($con,"SELECT * FROM users WHERE email = '$email' and user_closed = 'yes' ");
        // if we found one, we are opening his account
        if(mysqli_num_rows($select_user_closed_query) == 1){
            mysqli_query($con,"UPDATE users SET user_closed='no' WHERE email = '$email' ");
        }
        header('Location:index.php');
        exit();
    }else{
        array_push($errorarray,"Email or password are not correct<br>");

    }





}