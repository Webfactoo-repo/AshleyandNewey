<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->

  <?php
    do_action('get_header');
  ?>

  <div class="wrap" role="document">
    <div class="container">
      <div class="leftbar <?php if (is_user_logged_in()){ echo 'logged';} ?>">
          <?php get_template_part('templates/leftbar');?>
      </div>
      <div class="main <?php echo roots_main_class(); ?>" role="main">
        <?php include roots_template_path(); ?>
      </div><!-- /.main -->
    </div><!-- /.content -->
  </div><!-- /.wrap -->

<!--  --><?php //get_template_part('templates/footer'); ?>
  <?php wp_footer(); ?>
</body>
</html>
