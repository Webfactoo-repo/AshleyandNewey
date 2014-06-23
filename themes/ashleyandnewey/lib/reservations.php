<?php

//delete post

function delete_data($post_id) {

    global $wpdb;

    $wpdb->query("DELETE FROM andev_reservations WHERE tour_id = '$post_id'");

}

add_action('delete_post', 'delete_data');



//remove tags

function remove_submenus() {

    global $submenu;

    unset($submenu['edit.php'][16]); // Removes 'Tags'.

}

add_action('admin_menu', 'remove_submenus');



//change labels

function change_post_menu_label() {

    global $menu;

    global $submenu;

    $menu[5][0] = 'Tours';

    $submenu['edit.php'][5][0] = 'Tours';

    $submenu['edit.php'][10][0] = 'Add Tours';

    $submenu['edit.php'][15][0] = 'Categories';

    echo '';

}

function change_post_object_label() {

    global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;

    $labels->name = 'Tours';

    $labels->singular_name = 'Tour';

    $labels->add_new = 'Add Tours';

    $labels->add_new_item = 'Add Tour';

    $labels->edit_item = 'Edit Tour';

    $labels->new_item = 'Tour';

    $labels->view_item = 'View Tour';

    $labels->search_items = 'Search Tours';

    $labels->not_found = 'No Tours found';

    $labels->not_found_in_trash = 'No Tours found in Trash';

}

add_action( 'init', 'change_post_object_label' );

add_action( 'admin_menu', 'change_post_menu_label' );



//add reservations

function add_submenus() {

    global $pw_settings_page;

    $pw_settings_page[] = add_posts_page('Reservations', 'Reservations', 'read', 'reservations', 'reservations_function');
    $pw_settings_page[] = add_posts_page('Reserve as', 'Reserve as', 'read', 'reserveas', 'reserveas_function');

}

add_action('admin_menu', 'add_submenus');



//js and css

function pw_load_scripts($hook) {

    global $pw_settings_page;

    if( !in_array($hook, $pw_settings_page ))

        return;


    wp_enqueue_script( 'jquery-js', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');

    wp_enqueue_script( 'dataTables-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.min.js');

    wp_enqueue_script( 'dataTables-ColVis-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.ColVis.min.js');

    wp_enqueue_script( 'ZeroClipboard-js', '/wp-content/themes/ashleyandnewey/assets/js/ZeroClipboard.js');

    wp_enqueue_script( 'dataTables-TableTools-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.TableTools.min.js');

    wp_enqueue_script( 'main-admin-js', '/wp-content/themes/ashleyandnewey/assets/js/main-admin.js');



    wp_enqueue_style( 'dataTables-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.css' );

    wp_enqueue_style( 'dataTables-ColVis-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.ColVis.css' );

    wp_enqueue_style( 'dataTables-TableTools-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.TableTools.css' );

    wp_enqueue_style( 'style-admin-css', '/wp-content/themes/ashleyandnewey/assets/css/style-admin.css' );

}

add_action('admin_enqueue_scripts', 'pw_load_scripts');



//reservations

function reservations_function(){

    global $wpdb;

    $reservations = $wpdb->get_results(

        "SELECT * FROM andev_reservations ORDER BY time"

    );

    ?>

    <div id="rTable" class="ad-table">

        <table cellpadding="0" cellspacing="0" border="0" class="display" id="reservation-table">

            <thead>

            <tr>

                <th>Tour</th>

                <th>Date</th>

                <th>Company</th>

                <th>Name</th>

                <th>Reserve date</th>

                <th>Confirmation</th>

                <th>Delete</th>

            </tr>

            </thead>

            <tbody>

            <?php

            foreach ($reservations as $reservation){

                $user_info = get_userdata($reservation->user_id);

                ?>

                <tr data-id="<?php echo $reservation->id; ?>">

                    <td class="center"><?php echo get_the_title($reservation->tour_id); ?> </td>

                    <td class="center"><?php echo str_replace("\\", "", $reservation->date); ?></td>

                    <td class="center"><?php echo $user_info->last_name; ?></td>

                    <td class="center"><?php echo $user_info->first_name; ?></td>

                    <td class="center"><?php echo $reservation->time; ?></td>

                    <td class="center">

                        <?php global $current_user; ?>
                        <?php if (isset($current_user->caps['administrator']) && $reservation->status == 1) : ?>
                            <button type="button" class="confirmation" data-id="<?php echo $reservation->id; ?>" onclick="alert('Are you sure?');">
                                Confirmation
                            </button>
                        <?php endif; ?>

                    </td>

                    <td class="center">

                        <button type="button" class="delete" data-id="<?php echo $reservation->id; ?>" onclick="return conf('Are you sure?');">Delete</button>

                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

            <tfoot>

            <tr>

                <th>Tour</th>

                <th>Date</th>

                <th>Company</th>

                <th>Name</th>

                <th>Reserve date</th>

                <th>Confirmation</th>

                <th>Delete</th>

            </tr>

            </tfoot>

        </table>

    </div>

<?php

}

//Reserve as

function reserveas_function(){

    global $wpdb;

$args = array(
	'posts_per_page'   => 3000,
	'offset'           => 0,
	'category'         => 10,9,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'suppress_filters' => true );
    $tours = get_posts($args);

	$standard_users = get_users('role=standard');
	$standard_users_select = "<option data-id='no'>Please select a Partner!</option>";
	foreach ($standard_users as $user) {
		$standard_users_array[$user->ID]["name"] = $user->first_name;
		$standard_users_array[$user->ID]["company"] = $user->last_name;
		$standard_users_select .= "<option data-id='" . $user->ID . "'>" . $user->first_name . " - " . $user->last_name . "</option>";
	}

	$premium_users_select = "<option data-id='no'>Please select a Partner!</option>";
	$premium_users = get_users('role=premium');
	foreach ($premium_users as $user) {
		$premium_users_array[$user->ID]["name"] = $user->first_name;
		$premium_users_array[$user->ID]["company"] = $user->last_name;
		$premium_users_select .= "<option data-id='" . $user->ID . "'>" . $user->first_name . " - " . $user->last_name . "</option>";
	}
	
	$statuses = array(
		0		=> "free",
		1		=> "reserved",
		2		=> "confirmed"
	);
	
    $reservations = $wpdb->get_results(
        "SELECT * FROM andev_reservations ORDER BY tour_id"
	);

	$orgReservations = array();
	foreach ($reservations as $reservation) {
	    $orgReservations[$reservation->tour_id][] = $reservation;
	}

    ?>
    <div id="rTable" class="ad-table">

        <table cellpadding="0" cellspacing="0" border="0" class="display" id="reservation-table">

            <thead>

            <tr>

                <th>ID</th>

                <th>Title</th>

                <th>Categories</th>

                <th>Content</th>

                <th>Date</th>

                <th>Group</th>

                <th>Status</th>

                <th>Reserved by</th>

                <th>Change</th>

                <th>Unreserve</th>

            </tr>

            </thead>

            <tbody>

            <?php

            foreach ($tours as $tour){
                $dates = get_field("dates", $tour->ID);
				$usergroup = array_pop(get_post_meta($tour->ID, "usergroup"));
				$cats = get_the_category($tour->ID);
				$tourcatarr = "";
				foreach ($cats as $cat) {
					$tourcatarr[] = $cat->cat_name;
				}
				$tourcatdisplay = join ("<br />", $tourcatarr);
				

                 foreach ($dates as $date) {
                    $dateid = $date['date_id'];
                    $start = strtotime($date['start_date']);
                    $end = strtotime($date['end_date']);
                    $atime = date("j M Y -", $start) . date(" j M Y", $end);
					$reservation = "";
                    $user_info = "";
	                $reservationstatus = 0;
	                $reservationid = 0;
	                $userdisplay = "";
	                $selectdata = "data-dateid='" . $dateid . "' data-tourid='" . $tour->ID . "' data-date='" . $atime . "'";
                    if (isset($orgReservations[$tour->ID]) && is_array($orgReservations[$tour->ID])) {
	                    foreach ($orgReservations[$tour->ID] as $reservation) {
	                        if ($reservation->date_id == $dateid) {
	                        	$reservationstatus = $reservation->status;
	                        	$reservationid = $reservation->id;
	                            $user_info = get_userdata($reservation->user_id);
	                            $userdisplay = $user_info->first_name . "<br />" . $user_info->last_name;
	                        } else {
	                        }
	                    }
	                }
                    $selectdata .= " data-resid='" . $reservationid . "'";
                ?>

	                <tr data-id="<?php echo $tour->ID; ?>" data-dateid="<?php echo $dateid; ?>">
	
	                    <td class="center"><?php echo $tour->ID; ?> </td>
	
	                    <td class="center"><?php echo $tour->post_title ?> </td>
	
	                    <td class="center"><?php echo $tourcatdisplay ?> </td>
	
	                    <td class="center"><?php echo strip_tags(substr($tour->post_content, 0, 100)); ?> </td>
	
	                    <td class="center"><?php echo $atime ?>
	
	                    <td class="center"><?php echo $usergroup ?>

	                    <td class="center status "><?php echo $statuses[$reservationstatus]; ?>
	
	                    <td class="center reserver "><?php echo $userdisplay; ?></td>
	
						<td class="center">
	                    	<div class="reldiv" style="position:relative;">
	                        <?php global $current_user; ?>
	                        <?php if (isset($current_user->caps['administrator'])) : ?>
								<button type="button" class="change" data-tourid="<?php echo $tour->ID; ?>" data-dateid="<?php echo $dateid; ?>">Change</button>
	                        <?php endif; ?>
								<div style="position: absolute; top: 0px; right:100px;background: white;border:1px solid black;display:none" class="selectdiv">
									<select class="res_select" <?php echo $selectdata; ?>>
										<?php echo ($usergroup == "standard" ? $standard_users_select: $premium_users_select); ?>
									</select>
								</div>
							</div>	                    
						</td>
	
						<td class="center ">
						
	                        <?php global $current_user; ?>
	                        <?php if (isset($current_user->caps['administrator'])) : ?>
								<button type="button" class="unreserve" data-resid="<?php echo $reservationid; ?>" data-dateid="<?php echo $dateid; ?>" data-tourid="<?php echo $tour->ID; ?>" style="display:<?php echo ($reservationid == 0 ? 'none' : 'inline') ?>" >Unreserve</button>
	                        <?php endif; ?>
	
						</td>
	
	
	                </tr>
	
            <?php

				}
	        }
            

            ?>

            </tbody>

            <tfoot>

            <tr>

                <th>ID</th>

                <th>Title</th>

                <th>Categories</th>

                <th>Content</th>

                <th>Date</th>

                <th>Group</th>

                <th>Status</th>

                <th>Reserved by</th>

                <th>Change</th>

                <th>Unreserve</th>

            </tr>


            </tfoot>

        </table>

    </div>

<?php

}



?>