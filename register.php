<?php
require "config/config.php";
require "includes/form_handlers/register_handler.php";
require "includes/form_handlers/login_handler.php";



?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to twirl</title>
    <link rel="stylesheet" href="assets/css/register_style.css">
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
</head>
<body>
  <?php
     if(isset($_POST['reg_button'])){
         echo "
         <script>
          $(document).ready(function(){
             $('#first').hide();
             $('#second').show();
          });
          
          </script>
         ";
     }

  ?>

  <div class="wrapper">

      <div class="login_box">
          <div class='login_header'>
              <h1>Twirlfeed</h1>
               <p>Login or sign up below!</p>
          </div>
          <div id="first">
              <form action="register.php" method="post">
                  <input type="email" name="log_email" placeholder="E-mail" required value="<?php echo isset( $_SESSION['email'])? $_SESSION['email']:''; ?>">
                  <br>
                  <input type="password" name="log_password" placeholder="Password" required>
                  <br>
                  <input type="submit" name="btn_login" value="Login">

                  <br>
                  <?php if(in_array("Email or password are not correct<br>",$errorarray)) echo "Email or password are not correct<br>" ?>

                  <a href="#" id="signup" class="signup">Need an account?Register here!</a>
              </form>
          </div>




          <div id="second">
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
                  <br>
                  <a href="#" id="signin" class="signin">Already have an account ?Sign in here!</a>
              </form>
          </div>




      </div>
  </div>
  <script src="assets/js/register.js"></script>
</body>
</html>