<div id="basic-page">

    <?php
    if ( is_page(4) ) {
    ?>
        <form method="POST" action="" class="request">
            <div id="reg-input">
                <input type="text" name="name" id="name" placeholder="NAME"/>
                <input type="text" name="email" id="email" placeholder="EMAIL"/>
                <input type="text" name="phone" id="phone" placeholder="PHONE"/>
            </div>
            <div id="reg-send" class="send">
                <input type="submit" value="send" id="send"/>
            </div>
        </form>
    <?php
    } elseif( is_page(14) ) {
    ?>
        <form method="POST" action="" class="forgot">
            <div id="for-input">
                <input type="text" name="email" id="email" placeholder="EMAIL"/>
            </div>
            <div id="for-send" class="send">
                <input type="submit" value="send" id="send"/>
            </div>
        </form>
    <?php
    } elseif ( is_page(27) ){
        if (isset($_GET['key'])){
        $key = $_GET['key'];
        $id = $wpdb->get_var("SELECT ID FROM andev_users WHERE user_activation_key='$key'");
        ?>
            <form method="POST" action="" class="change">
                <div id="change-input">
                    <input type="hidden" name="userid" id="userid" value="<?php echo $id ?>" />
                    <input type="password" name="newpassword" id="newpassword" placeholder="NEW PASSWORD"/>
                    <input type="password" name="newpassworda" id="newpassworda" placeholder="NEW PASSWORD AGAIN"/>
                </div>
                <div id="change-send" class="send">
                    <input type="submit" value="save" id="save"/>
                </div>
            </form>
        <?php
        } else {
        ?>
            <script type="text/javascript">
                window.location= <?php echo "'" . home_url() . "/forgot-my-password'"; ?>;
            </script>
        <?php
        }
    }
    ?>

    <div class="basic-content">
        <div id="title"><?php the_title(); ?></div>
        <div id="content">
            <?php
            if (isset($_GET['key']) && !$id){
                echo 'The activation key is wrong.';
            } else {
                if (have_posts()) : while (have_posts()) : the_post();
                    the_content();
                endwhile; endif;
            }
            ?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>