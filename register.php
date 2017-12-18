<?php session_start();

$con = mysqli_connect('localhost','root','lucy','twirl');


if(mysqli_connect_errno()){

die('Connection failed '.mysqli_connect_errno());
}

//Declaring variables to prevent errors
$fname =  '';
$lname = '';
$em ='';
$em2 = '';
$pass1 = '';
$pass2 ='';
$date ='';
$errorarray = array();

if(isset($_POST['reg_button'])) {
  $fname = strip_tags($_POST['reg_fname']);// remove the html tags
  $fname = str_replace(" ","",$fname);//replacing spaces with nothing
  $fname = ucfirst(strtolower($fname));// uppercasing the first word of the string that we have make  with lower case

  $_SESSION['fname'] = $fname;// we are creating sessions for filling the value attributes with old values


  $lname = strip_tags($_POST['reg_lname']);
  $lname = str_replace(" ","",$lname);
  $lname = ucfirst(strtolower($lname));

    $_SESSION['lname'] = $lname;

    $em = strip_tags($_POST['reg_email1']);
    $em = str_replace(" ","",$em);
    $em = strtolower($em);

    $_SESSION['em'] = $em;

    $em2 = strip_tags($_POST['reg_email2']);
    $em2 = str_replace(" ","",$em2);
    $em2 = strtolower($em2);

    $_SESSION['em2'] = $em2;

    $pass1 = strip_tags($_POST['reg_password1']);
    $pass2 = strip_tags($_POST['reg_password2']);

    $date = date("d-M-Y");//Current date


    //if emails are the same
   if($em==$em2){
       //first checking if the email is in valid format then validating email
       if(filter_var($em,FILTER_VALIDATE_EMAIL)){ // it returns 0 or 1
           $em = filter_var($em,FILTER_VALIDATE_EMAIL);

           //checking if email is already in use
           $em_exists =  mysqli_query($con,"SELECT email from users where email = '$em' ");
           if(mysqli_num_rows($em_exists)>0){
               array_push($errorarray,"Email is already in use!<br>");
           }

       }else{
           array_push($errorarray,"Invalid format<br>");
       }

   }else {
       array_push($errorarray,"Emails do not match<br>");
   }


   if(strlen($fname)>25 || strlen($fname)<2){

       array_push($errorarray,"Your first name must contain between 2 and 25 characters<br>");
   }

    if(strlen($lname)>25 || strlen($lname)<2){
        array_push($errorarray,"Your last name must contain between 2 and 25 characters<br>");
    }

    //check if the passwords are not the same
    if($pass1 != $pass2){
        array_push($errorarray,"Passwords do not match<br>");
    }else{
        //if we have same passwords
          //we are asking if the password length is less than 6 characters
        if (strlen($pass1) <= 6) {
            array_push($errorarray,"Your Password Must Contain At Least 6 Characters!<br>");
            //we are asking if the password has at least one number
        }elseif(!preg_match("#[0-9]+#",$pass1)) {
            array_push($errorarray,"Your Password Must Contain At Least 1 Number!<br>");
        }
            //we are asking if the password has at least one capital letter
        elseif(!preg_match("#[A-Z]+#",$pass1)) {
            array_push($errorarray,"Your Password Must Contain At Least 1 Capital Letter!<br>");
        }
             //we are asking if the password has at least one lower case letter
        elseif(!preg_match("#[a-z]+#",$pass1)) {
            array_push($errorarray,"Your Password Must Contain At Least 1 Lowercase Letter!<br>");
        }
    }

    if(empty($errorarray)){
        $password = md5($pass1);
        $username =  strtolower($fname. "_".$lname);
        $check_username_query = mysqli_query($con,"SELECT username from users WHERE username = '$username' ");
        $i = 0;
        //we are looping and  adding 1 to username as long as the number of rows in query is not 0(we are looping as long as  we are having users with same username in the users table)
        while(mysqli_num_rows($check_username_query) != 0){
            $i++;
            $username = $username."_".$i;
            $check_username_query = mysqli_query($con,"SELECT username from users WHERE username = '$username' ");
        }

          //saving all files from defaults folder in array
        $default_pics_array = scandir("assets/images/profile_pics/defaults");
         //removing first two elements from the array
        $default_pics_array = array_slice($default_pics_array,2);

       //random number from the indexes in the array
        $random_number = rand(0,count($default_pics_array)-1);

       // picking random file
        $profile_pic = "assets/images/profile_pics/defaults/".$default_pics_array[$random_number];

        $insertquery =mysqli_query($con,"INSERT INTO users VALUES(null,'$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0',',','no')");

        array_push($errorarray, "<span style='color:#0adb8f'>You've completed registration!Proceed to login</span><br>");

       //print_r($_SESSION);//Array ( [fname] => Lucy [lname] => Ristova [em] => lucy234@gmail.com [em2] => lucy234@gmail.com )
          //unsetting all session variables
        foreach($_SESSION as $key=>$value){
            unset($_SESSION[$key]);
        }
    }



}

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to twirl</title>
</head>
<body>
<form action="register.php" method="post">
    <input type="text" name="reg_fname" placeholder="First Name" required value="<?php echo isset($_SESSION['fname'])?$_SESSION['fname']:'' ?>">
    <br>
    <?php if(in_array("Your first name must contain between 2 and 25 characters<br>",$errorarray))
        echo "Your first name must contain between 2 and 25 characters<br>";
    ?>
    <input type="text" name="reg_lname" placeholder="Last Name" required value="<?php echo isset($_SESSION['lname'])?$_SESSION['lname']:'' ?>" >
    <br>
    <?php if(in_array("Your last name must contain between 2 and 25 characters<br>",$errorarray))
        echo "Your last name must contain between 2 and 25 characters<br>";
    ?>
    <input type="email" name="reg_email1" placeholder="Email" required value="<?php echo isset($_SESSION['em'])?$_SESSION['em']:'' ?>" >
    <br>
    <input type="email" name="reg_email2" placeholder="Confirm email" required value="<?php echo isset($_SESSION['em2'])?$_SESSION['em2']:'' ?>" >
    <br>
    <?php if(in_array("Emails do not match<br>",$errorarray))
        echo "Emails do not match<br>";
      elseif (in_array("Email is already in use!<br>",$errorarray))
        echo "Email is already in use!<br>";
    elseif (in_array("Invalid format<br>",$errorarray))
        echo "Invalid format<br>";
    ?>
    <input type="password" name="reg_password1" placeholder="Password" required>
    <br>
    <input type="password" name="reg_password2" placeholder="Confirm password" required>
    <br>
    <?php if(in_array("Passwords do not match<br>",$errorarray))
        echo "Passwords do not match<br>";
    elseif (in_array("Your Password Must Contain At Least 6 Characters!<br>",$errorarray))
        echo "Your Password Must Contain At Least 6 Characters!<br>";
    elseif (in_array("Your Password Must Contain At Least 1 Number!<br>",$errorarray))
        echo "Your Password Must Contain At Least 1 Number!<br>";
    elseif (in_array("Your Password Must Contain At Least 1 Capital Letter!<br>",$errorarray))
        echo "Your Password Must Contain At Least 1 Capital Letter!<br>";
    elseif (in_array("Your Password Must Contain At Least 1 Lowercase Letter!<br>",$errorarray))
        echo "Your Password Must Contain At Least 1 Lowercase Letter!<br>";
    ?>

    <?php
    if(in_array("<span style='color:#0adb8f'>You've completed registration!Proceed to login</span><br>",$errorarray))
        echo "<span style='color:#0adb8f'>You've completed registration!Proceed to login</span><br>";
    ?>
    <input type="submit" name="reg_button" value="Register">
</form>

</body>
</html>