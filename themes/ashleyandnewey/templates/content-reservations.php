<?php
if (!is_user_logged_in()){
?>
<script type="text/javascript">
    window.location= <?php echo "'" . home_url() . "'"; ?>;
</script>
<?php
} else {
    get_template_part('templates/content', 'page-header');
    ?>
    <div id="tours-page" class="my-reservations">
        <ul class="content">
        <?php
        $current_user = wp_get_current_user();
        $reservations = $wpdb->get_results(
            "SELECT * FROM andev_reservations ORDER BY tour_id"
        );
        $orgReservations = array();
        foreach ($reservations as $reservation){
            $orgReservations[$reservation->tour_id][] = $reservation;
        }

        $args = array(
            'orderby' => 'name',
            'order' => 'ASC'
        );
        query_posts( $args );
        wp_pagenavi( array('query' => $wp_query) );

        while (have_posts()) : the_post();
            $category_detail=get_the_category( $post->ID );
            $user_res = 0;
            if (is_array($orgReservations[$post->ID])) {
	            foreach($orgReservations[$post->ID] as $reservation){
	                if ($current_user->ID == $reservation->user_id && $reservation->status == 2){
	                    $user_res = 1;
	                }
	            }
	        }
            if ($user_res == 1){
            ?>
                <li>
                <div data-id="<?php echo $post->ID ?>" class="tour tour-norm<?php
                foreach ($category_detail as $row){
                    echo " ".$row->cat_ID;
                }
                ?>">

                    <div class="dates-popup hidden">
                        <table>
                            <tr>
                                <th>Date</th>
                                <th>Booking status</th>
                                <th>Date</th>
                                <th>Booking status</th>
                            </tr>
                            <?php
                            $dates = get_field( "dates" );
                            $counter = 2;
                            foreach($dates as $date){
                                if ($counter % 2 == 0){
                                    echo '<tr>';
                                }
                                ?>
                                <?php
                                $dateid=$date['date_id'];
                                $start = strtotime($date['start_date']);
                                $end = strtotime($date['end_date']);
                                $atime = date("j M Y -", $start) . date(" j M Y", $end);
                                echo "<td>".$atime."</td>";
                                ?>
                                <td>
                                    <?php
                                    $in = 0;
                                    $user_res = 0;
                                    if (is_array($orgReservations[$post->ID])) {
	                                    foreach($orgReservations[$post->ID] as $reservation){
	                                        if ($current_user->ID == $reservation->user_id && $reservation->status == 2){
	                                            $user_res = 1;
	                                        }
	                                        if ($reservation->date_id == $dateid){
	                                            $user_info = get_userdata($reservation->user_id);
	                                            $in = 1;
	                                            if($reservation->status == 1){
	                                                echo '(opt) '.$user_info->last_name;
	                                            } else {
	                                                echo $user_info->last_name;
	                                            }
	                                        }
	                                    }
                                    }
                                    if ($in == 0){
                                        echo 'free';
                                    }
                                    ?>
                                </td>
                                <?php
                                $counter++;
                                if ($counter % 2 == 0){
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>

                    <div class="thumbnail" data-id="<?php echo $post->ID ?>">
                        <?php
                        if ($user_res == 1) {
                            $image_id = 0;
                            $image_id = get_post_thumbnail_id();
                            if ($image_id != 0){
                                $image_url = wp_get_attachment_image_src($image_id,'thumbnail', true);
                                $urls = substr($image_url[0], 0, -4);
                                $urle = substr($image_url[0], -4);
                                $url = $urls."-an".$urle;
                                echo '<img src="'.$url.'">';
                            }
                        } else {
                            the_post_thumbnail('thumbnail');
                        }
                        ?>
                    </div>
                    <div class="title"><?php the_title(); ?></div>
                    <div class="excerpt ownreservations" data-id="<?php echo $post->ID ?>">
                        <?php
                        $ores=0;
                        if (is_array($orgReservations[$post->ID])) {
	                        foreach($orgReservations[$post->ID] as $reservation){
	                            if ($reservation->user_id == $current_user->ID){
	                                $ores++;
	                                if($ores == 1){
	                                    echo $reservation->date;
	                                } else {
	                                    echo " • ".$reservation->date;
	                                }
	                                if ($ores == 3){
	                                    echo "<br>";
	                                    $ores=0;
	                                }
	                            }
	                        }
                        }
                        ?>
                    </div>
                    <div class="icons">
                        <div class="bell" title="Booking status"></div>
                        <div class="arrow" title="Open"></div>
                    </div>
                    <div class="triangle hidden" data-id="<?php echo $post->ID ?>">
                    </div>
                </div>
                <div class="clear"></div>
                <div data-id="<?php echo $post->ID ?>" class="tour-content hidden<?php
                foreach ($category_detail as $row){
                    echo " ".$row->cat_ID;
                }
                ?>">
                    <div class="dates">
                        <h2>Tour Dates</h2>
                        <div class="hmessage"><p>YOU CAN PLACE AN OPTION ON FREE DATES BY CLICKING THE</p> <div class="belli"></div><p>ICON.</p><p>WE WILL CONFIRM BACK TO YOU WITHIN 48 HOURS.</p></div>
                        <div class="clear"></div>
                        <table>
                            <tr>
<!--                                <th></th>-->
                                <th>Date</th>
                                <th>Booking status</th>
                            </tr>
                            <?php
                            $dates = get_field( "dates" );
                            foreach($dates as $date){
                                $dateid=$date['date_id'];
                                $start = strtotime($date['start_date']);
                                $end = strtotime($date['end_date']);
                                $atime = date("j M Y -", $start) . date(" j M Y", $end);
                                ?>
                                <tr>
<!--                                    <td><div title="Reserve this date" class="bell" data-dateid="--><?php //echo $dateid; ?><!--" data-date="--><?php //echo $atime; ?><!--" data-id="--><?php //echo $post->ID ?><!--"></div></td>-->
                                    <?php
                                    echo "<td class='time'>".$atime."</td>";
                                    ?>
                                    <td class="state">
                                        <?php
                                        $in = 0;
                                        $xls[] = $atime;
                                        if (is_array($orgReservations[$post->ID])) {
	                                        foreach($orgReservations[$post->ID] as $reservation){
	                                            if ($reservation->date_id == $dateid){
	                                                $user_info = get_userdata($reservation->user_id);
	                                                $in = 1;
	                                                if($reservation->status == 1){
	                                                    echo '(opt) '.$user_info->last_name;
	                                                    $xls[] = '(opt) '.$user_info->last_name;
	                                                } else {
	                                                    echo $user_info->last_name;
	                                                    $xls[] = $user_info->last_name;
	                                                }
	                                            }
	                                        }
                                        }
                                        if ($in == 0){
                                            echo "free";
                                            $xls[] = "free";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                        <div class="xlsData">
                            <table>
                                <tr>
                                    <th>Date</th>
                                    <th>Booking status</th>
                                </tr>
                                <?php
                                $xls_num = 2;
                                foreach($xls as $xls_e){
                                    if($xls_num % 2 == 0){
                                        echo "<tr>";
                                    }
                                    echo "<td>".$xls_e."</td>";
                                    if($xls_num % 2 != 0){
                                        echo "</tr>";
                                    }
                                    $xls_num++;
                                }
                                $xls = array();
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="documents">
                        <h2>Documents</h2>
                        <div class="clear"></div>
                        <div class="selector">
                            <?php
                            $documents = get_field( "documents" );
                            if( get_field('documents') ){
                                $num = count($documents);
                                $counter = 1;
                                $url = "";
                                while( has_sub_field('documents') ){
                                    $document = get_sub_field('document');
                                    $document_name = get_sub_field('document_name');
                                    if ($counter == 1){
                                        $ext = pathinfo($document['url'], PATHINFO_EXTENSION);
                                        $file_size = findFilesize($document['url']);
                                        echo "<a href='#' class='docsel active' data-url='".basename($document['url'])."'>".$document_name." (".$ext.",".$file_size.")</a>";
                                        $url = basename($document['url']);
                                    } else {
                                        echo "<a href='#' data-url='".basename($document['url'])."'>".$document_name." (".$ext.",".$file_size.")</a>";
                                    }
                                    echo " | ";
                                    $counter++;
                                }
                            }
                            ?>
                            <a href='#' class="bstatus">Booking status (xls)</a>
                        </div>
                        <div class="icons" data-url="<?php echo $url; ?>">
                            <div class="open" title="Open"></div>
                            <div class="download" title="Download"></div>
                            <div class="email" title="Send in mail"></div>
                        </div>

                    </div>

                    <div class="photos">
                        <h2>Photos</h2>
                        <div class="clear"></div>
                        <div class="swiper-container" id="sc<?php echo $post->ID ?>">
                            <div class="swiper-wrapper">
                                <?php
                                $photos = get_field('photos');
                                $photosnum = 0;
                                if( get_field('photos') ){
                                    while( has_sub_field('photos') ){
                                        $photosnum++;
                                        $photo_name = get_sub_field('photo_name');

                                        $attachment_id = get_sub_field('photo');
                                        // (thumbnail, medium, large, full or custom size)
                                        if ($user_res == 1){
                                            $url_op = wp_get_attachment_image_src( $attachment_id, "full" );
                                            $url_ops = substr($url_op[0], 0, -4);
                                            $url_ope = substr($url_op[0], -4);
                                            $url_op[0] = $url_ops."-an".$url_ope;

                                            $url = wp_get_attachment_image_src( $attachment_id, "thumbnail" );
                                            $urls = substr($url[0], 0, -4);
                                            $urle = substr($url[0], -4);
                                            $url[0] = $urls."-an".$urle;
                                        } else {
                                            $url_op = wp_get_attachment_image_src( $attachment_id, "full" );
                                            $url = wp_get_attachment_image_src( $attachment_id, "thumbnail" );
                                        }
                                        ?>
                                        <div class="swiper-slide">
                                            <div class="swiper-slide-cont">
                                                <a class="fancybox" href="<?php echo $url_op[0]; ?>" rel="gallery<?php echo $post->ID ?>" title="<?php echo $photo_name; ?>"><img src="<?php echo $url[0]; ?>" width="140px" height="110px"></a>
                                                <?php
                                                if ($user_res == 1){
                                                    ?>
                                                    <div class="download" data-url="<?php echo $url_op[0]; ?>"></div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($photosnum > 4){
                            ?>
                            <div class="swiper-scrollbar" id="sb<?php echo $post->ID ?>"></div>
                        <?php
                        }
                        ?>
                        <p>Please note that the license for  images is non-transferable. You can only use the images for the tours you booked by Ashley&Newey. You can only use the images in the actual year. You can use the images in your brochures, leaflets or on your website (provided that no Image is displayed at a resolution greater than 800 x 600 pixels).</p>

                    </div>
                </div>
                <div class="clear"></div>
                </li>
        <?
            }
            endwhile;
        wp_reset_query();
        ?>
    </ul>
<?php            wp_pagenavi( array('query' => $wp_query) ); ?>
    </div>
    <div id="toPopup">

        <div id="popup_content">
        </div>

    </div>
    <div id="backgroundPopup"></div>
    <?php
}
?>
