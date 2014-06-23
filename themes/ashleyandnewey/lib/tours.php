<?php

function pw_load_script_date($hook) {
    if( $hook != 'post.php' && $hook != 'post-new.php' )
        return;

    wp_enqueue_script( 'tours-js', '/wp-content/themes/ashleyandnewey/assets/js/tours.js');
    wp_enqueue_style( 'tours-css', '/wp-content/themes/ashleyandnewey/assets/css/tours.css' );
}

add_action('admin_enqueue_scripts', 'pw_load_script_date');

//metabox
function wpse33063_move_meta_box(){
    remove_meta_box( 'wpseo_meta', 'post', 'normal' );
}

add_action('do_meta_boxes', 'wpse33063_move_meta_box');

function oander_addTourScriptToAdmin() {
    global $parent_file;
    $currrScr = get_current_screen();

    if ( $parent_file == 'edit.php' && $currrScr->base != "posts_page_reservations") {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('body').on('click', '#acf-dates tr .acf-date_picker input', function(){
                	if (jQuery(this).val() == '' && jQuery(this).parent('div').parent('td').parent('tr').prev().length>0) {
	                    prevDateForCopy = '1';
	                    jQuery(this).parent('div').parent('td').parent('tr').prev().children('td').each(function(){
	                        if (jQuery(this).attr('data-field_name') == 'end_date' && jQuery(this).children('div').children('.input').val() != '') {
	                            prevDateForCopy = jQuery(this).children('div').children('.input').val();
	                        }
	                    });
                    jQuery(this).val(prevDateForCopy);
                    var anotherDateFormatArr = new Array();
                    anotherDateFormatArr = prevDateForCopy.split('/');
                    var anotherDateFormatStr = anotherDateFormatArr[2] + anotherDateFormatArr[1] + anotherDateFormatArr[0];
                    jQuery(this).siblings('.input-alt').val(anotherDateFormatStr);
	                };
				});
                jQuery('#acf-dates tr .acf-date_picker input').live('change', function(){
                    var startDateForCopy = '';
                    jQuery(this).parent('div').parent('td').parent('tr').children('td').each(function(){
                        if (jQuery(this).attr('data-field_name') == 'start_date') {
                            startDateForCopy = jQuery(this).children('div').children('.input').val();
                        }
                    });

                    jQuery(this).parent('div').parent('td').parent('tr').children('td').each(function(){
                        if (jQuery(this).attr('data-field_name') == 'end_date') {
                            if (jQuery(this).children('div').children('.input').val() == '') {
                                jQuery(this).children('div').children('.input').val(startDateForCopy);
                                var anotherDateFormatArr = new Array();
                                anotherDateFormatArr = startDateForCopy.split('/');
                                var anotherDateFormatStr = anotherDateFormatArr[2] + anotherDateFormatArr[1] + anotherDateFormatArr[0];
                                jQuery(this).children('div').children('.input-alt').val(anotherDateFormatStr);
                            }
                        }
                    });
                });
            });
        </script>
        <?php
    }
}

add_filter('admin_head', 'oander_addTourScriptToAdmin');

?>