<?php
function hide_instant_messaging( $contactmethods ) {
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    unset($contactmethods['twitter']);
    unset($contactmethods['googleplus']);
//    $contactmethods['facebook'] = 'Facebook';
    return $contactmethods;
}
add_filter('user_contactmethods','hide_instant_messaging',10,1);

class Hide_Profile{
    public static function start(){
        $action = ( IS_PROFILE_PAGE ? 'show' : 'edit' ) . '_user_profile';
        add_action( $action, array ( __CLASS__, 'stop' ) );
        ob_start();
    }

    public static function stop(){
        $html = ob_get_contents();
        ob_end_clean();

        ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("#your-profile .form-table:first, #your-profile h3:first").remove();
                jQuery("label[for='first_name']").html('Name');
                jQuery("label[for='last_name']").html('Company');
                jQuery("label[for='url']").html('Phone');
                //jQuery("input[name='url']").val();
                jQuery("#nickname,#display_name").parent().parent().remove();
                jQuery("#wordpress-seo").remove();
                jQuery(".form-table:last").remove();
            });
        </script>
        <?php

        $headline = __( IS_PROFILE_PAGE ? 'About Yourself' : 'About the user' );
        $html = str_replace( '<h3>' . $headline . '</h3>', '', $html );
        $headline = __( IS_PROFILE_PAGE ? 'Contact Info' : 'Contact Info' );
        $html = str_replace( '<h3>' . $headline . '</h3>', '', $html );
        $headline = __( IS_PROFILE_PAGE ? 'Name' : 'Name' );
        $html = str_replace( '<h3>' . $headline . '</h3>', '', $html );

        $html = preg_replace( '~<tr>\s*<th><label for="description".*</tr>~imsUu', '', $html );
        print $html;
    }
}
add_action( 'personal_options', array ( 'Hide_Profile', 'start' ) );

function theme_change_label_names($translated_text){
    if (is_admin()){
        switch ( $translated_text ) {

            case 'First Name' :
                $translated_text = __( 'Name', 'theme_text_domain' );
                break;

            case 'Last Name' :
                $translated_text = __( 'Company', 'theme_text_domain' );
                break;

            case 'Website' :
                $translated_text = __( 'Phone', 'theme_text_domain' );
                break;
        }

    }

    return $translated_text;
}
add_filter( 'gettext', 'theme_change_label_names');
?>