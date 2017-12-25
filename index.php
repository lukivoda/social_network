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
        <div class="form_style" style="overflow: hidden">
            <form action="index.php" method="post">
                <textarea name="body" id="posts_text" placeholder="Got something to say"></textarea>
                <input type="submit" name="btn_post" value="Post">
            </form>


        </div>
        <hr>

        <div class="posts_area"></div>

        <div style="text-align: center">
            <img src="assets/images/icons/loading.gif" alt="" id="loading" width="120" >
        </div>


</div>
<script>
    var userLoggedIn = '<?php echo $userLoggedIn; ?>';

    $(document).ready(function() {

        $('#loading').show();

        //Original ajax request for loading first posts
        $.ajax({
            url: "includes/handlers/ajax_load_posts.php",
            type: "POST",
            data: "page=1&userLoggedIn=" + userLoggedIn,
            cache:false,

            success: function(data) {
                $('#loading').hide();
                $('.posts_area').html(data);
            }
        });

        $(window).scroll(function() {
            var height = $('.posts_area').height(); //Div containing posts
            var scroll_top = $(this).scrollTop();
            var page = $('.posts_area').find('.nextPage').val();
            var noMorePosts = $('.posts_area').find('.noMorePosts').val();

            if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
                $('#loading').show();

                var ajaxReq = $.ajax({
                    url: "includes/handlers/ajax_load_posts.php",
                    type: "POST",
                    data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                    cache:false,

                    success: function(response) {
                        $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage
                        $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage

                        $('#loading').hide();
                        $('.posts_area').append(response);
                    }
                });

            } //End if

            return false;

        }); //End (window).scroll(function())


    });

</script

<footer>

</footer>
</body>
</html>

