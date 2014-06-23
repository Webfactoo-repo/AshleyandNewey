<?php

    function register_my_user_activity() {
        global $pw_useractivity_page;
        $pw_useractivity_page = add_submenu_page( 'index.php', 'User Activity', 'User Activity', 'read', 'user_activity', 'user_activity_function');
    }
    add_action('admin_menu', 'register_my_user_activity');


    function pw_load_scripts_activity($hook) {
        global $pw_useractivity_page;
        if( $hook != $pw_useractivity_page )
            return;

        wp_enqueue_script( 'jquery-js', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
        wp_enqueue_script( 'dataTables-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.min.js');
//        wp_enqueue_script( 'dataTables-ColVis-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.ColVis.min.js');
//        wp_enqueue_script( 'ZeroClipboard-js', '/wp-content/themes/ashleyandnewey/assets/js/ZeroClipboard.js');
//        wp_enqueue_script( 'dataTables-TableTools-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.TableTools.min.js');
        wp_enqueue_script( 'main-admin-js', '/wp-content/themes/ashleyandnewey/assets/js/main-admin.js');

        wp_enqueue_style( 'dataTables-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.css' );
//        wp_enqueue_style( 'dataTables-ColVis-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.ColVis.css' );
//        wp_enqueue_style( 'dataTables-TableTools-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.TableTools.css' );
        wp_enqueue_style( 'style-admin-css', '/wp-content/themes/ashleyandnewey/assets/css/style-admin.css' );
    }
    add_action('admin_enqueue_scripts', 'pw_load_scripts_activity');

    function user_activity_function(){
        global $wpdb;
        $activities = $wpdb->get_results(
            "SELECT * FROM andev_user_activity ORDER BY date"
        );
        ?>
        <div id="uTable" class="ad-table">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="useractivity-table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Operation</th>
                    <th>File / Tour</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($activities as $activity){
                    $user_info = get_userdata($activity->user_id);
                    ?>
                    <tr data-id="<?php echo $activity->id; ?>">
                        <td class="center"><?php echo $activity->date; ?></td>
                        <td class="center"><?php echo $user_info->last_name; ?></td>
                        <td class="center"><?php echo $user_info->first_name; ?></td>
                        <td class="center"><?php echo $activity->act; ?></td>
                        <td class="center"><?php echo $activity->file; ?></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Date</th>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Operation</th>
                    <th>File / Tour</th>
                </tr>
                </tfoot>
            </table>
        </div>
    <?php
    }

?>