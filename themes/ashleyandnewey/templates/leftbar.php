<?php
if (!is_user_logged_in()){
?>
    <nav class="nav" role="navigation">
        <?php
        if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav'));
        endif;
        ?>
    </nav>

    <div class="clear"></div>

    <form method="POST" action="" class="login">
        <div class="login-container">
            <div id="title"><p>For Our Partners</p></div>
            <input type="text" name="username" id="username" placeholder="USER NAME"/>
            <input type="text" name="password" id="password" placeholder="PASSWORD"/>
            <input type="submit" value="Ok" id="ok"/>
        </div>

        <div class="clear"></div>

        <nav class="login-nav" role="navigation">
        <?php
        if (has_nav_menu('login_navigation')) :
            wp_nav_menu(array('theme_location' => 'login_navigation', 'menu_class' => 'login-nav'));
        endif;
        ?>
        </nav>
    </form>

    <div class="clear"></div>

    <div class="message"></div>

    <a href="<?php echo home_url(); ?>/" class="logoa" title="<?php echo bloginfo('name'); ?>"><div class="logo"></div></a>
<?php
} else {
?>
    <nav class="logged-nav" role="navigation">
        <?php
        if (has_nav_menu('logged_navigation')) :
            wp_nav_menu(array('theme_location' => 'logged_navigation', 'menu_class' => 'logged-nav'));
        endif;
        ?>
    </nav>
    <a href="<?php echo home_url(); ?>/tours" title="<?php echo bloginfo('name'); ?>"><div class="logo"></div></a>
<?php
}
?>

<div class="information">
    <p>Ashley & Newey</p>
    <p>P.O. Box 124, Darlington</p>
    <p>Co Durham, DL2 2YX</p>
    <p>Tel: 01325 389567</p>
    <p>Fax: 01325 366834</p>
</div>

<div class="developed">
    <a href="http://www.adfactoo.co.uk" target="_blank">Developed by Adfactoo</a>
</div>