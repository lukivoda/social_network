<?php require 'config/config.php'; ?>
<?php include 'includes/classes/User.php';?>
<?php include 'includes/classes/Post.php';?>

<?php
//we are asking if the user is logged in
if(isset($_SESSION['username'])) {
    $userLoggedIn =  $_SESSION['username'];
    $userDetailsQuery =  mysqli_query($con,"SELECT * FROM users WHERE username =  '$userLoggedIn' ");
    if(mysqli_num_rows($userDetailsQuery) == 1){
        $user= mysqli_fetch_assoc($userDetailsQuery);

    }
}else {
    header("Location: register.php");
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Twirl Network</title>
    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
</head>
<body>

    <div class="top-bar">
        <div class="logo">
         <a href="index.php">TwirlFeed!</a>
        </div>
        <nav>
            <a href="<?php echo  $_SESSION['username'];  ?>"><?php echo $user['first_name']; ?></a>
            <a href="index.php"><i class="fa fa-envelope fa-lg"></i></a>
            <a href=""><i class="fa fa-home fa-lg"></i></a>
            <a href=""><i class="fa fa-bell fa-lg"></i></a>
            <a href=""><i class="fa fa-users fa-lg"></i></a>
            <a href=""><i class="fa fa-cog fa-lg"></i></a>
            <a href="includes/handlers/logout.php"><i class="fa fa-sign-out fa-lg"></i></a>
        </nav>
    </div>
    <div class="wrapper">