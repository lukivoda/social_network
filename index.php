<?php include "includes/header.php"; ?>
<?php if(isset($_POST['btn_post'])){
   $post = new Post($con,$userLoggedIn);
   $post->submitPost($_POST['body'],'none');

}
?>


    <div class="user_details column">

        <div class="user_detail_image">
            <a href="<?php echo   $userLoggedIn;  ?>"><img src="<?php echo $user['profile_pic']; ?>" alt=""></a>
        </div>
        <div class="user_detail_text">
            <p><a href="<?php echo  $userLoggedIn;  ?>">
                <?php echo $user['first_name']. " ".$user['last_name'] ?>
            </a></p>
            <p> Posts:<?php echo $user['num_posts'] ."</p>";?>
                <p>  Likes:<?php echo $user['num_likes'];?><p>
        </div>
    </div>
    <div class="main_column column">
        <div class="form_style">
            <form action="index.php" method="post">
                <textarea name="body" id="posts_text" placeholder="Got something to say"></textarea>
                <input type="submit" name="btn_post" value="Post">
            </form>

        </div>
    </div>
</div>
</body>
</html>

