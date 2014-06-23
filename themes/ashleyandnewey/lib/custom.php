<?php
//admin bar
//if (!current_user_can('administrator')):
    show_admin_bar(false);
//endif;

//slider
if( function_exists("register_new_royalslider_files") ){
    register_new_royalslider_files(1);
    register_new_royalslider_files(2);
    register_new_royalslider_files(3);
    register_new_royalslider_files(5);
}

// custom admin login logo
function custom_login_logo() {
    echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('template_directory').'/assets/css/pics/logo.png) !important; background-size:154px 179px!important; height:179px!important; margin-top:-70px!important;}
	</style>';
}
add_action('login_head', 'custom_login_logo');

//remove admin menu items
function fb_remove_menu_entries () {
        remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'fb_remove_menu_entries' );

//remove posts permalink
function posttype_admin_css() {
    global $post_type;
    if($post_type == 'post') {
        echo '<style type="text/css">#edit-slug-box,#view-post-btn,#post-preview,.updated p a{display: none;}</style>';
    }
}
add_action('admin_head', 'posttype_admin_css');

//remove category description, seo
function pw_load_script_cat($hook) {

    if( $hook != 'edit-tags.php' )
        return;
    ?>
    <style type="text/css">
        .form-field:last-of-type{
            display: none;
        }
        .form-table:last-of-type{
            display: none;
        }
        h2:last-of-type{
            display: none;
        }
    </style>
    <?php

}
add_action('admin_enqueue_scripts', 'pw_load_script_cat');



//logout url
function fix_logout_url( $url ){
    $url = str_replace( '& amp;', '&', $url );
    return $url;
}
add_filter('logout_url', 'fix_logout_url');

//pictures minimum size
function tc_handle_upload_prefilter($file){

    if(is_array(getimagesize($file['tmp_name']))){
        $img=getimagesize($file['tmp_name']);
        $minimum = array('width' => '300', 'height' => '300');
        $width= $img[0];
        $height =$img[1];

        if ($width < $minimum['width'] )
            return array("error"=>"Image dimensions are too small. Minimum width is {$minimum['width']}px. Uploaded image width is $width px");

        elseif ($height <  $minimum['height'])
            return array("error"=>"Image dimensions are too small. Minimum height is {$minimum['height']}px. Uploaded image height is $height px");
        else
            return $file;
    } else {
        return $file;
    }
}
add_filter('wp_handle_upload_prefilter','tc_handle_upload_prefilter');

//file size
function findFilesize($file) {
    $file = $_SERVER[DOCUMENT_ROOT]."/assets/".basename($file);

    if (is_file($file)) {
        $filePath = $file;
        if (!realpath($filePath)) {
            $filePath = $_SERVER["DOCUMENT_ROOT"].$filePath;
        }
        $fileSize = filesize($filePath);
        $sizes = array("TB","GB","MB","KB","B");
        $total = count($sizes);
        while ($total-- && $fileSize > 1024) {
            $fileSize /= 1024;
        }
        return round($fileSize, $digits)." ".$sizes[$total];
    }
    return false;
}
?>