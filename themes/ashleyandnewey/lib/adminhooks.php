<?php
add_action( 'restrict_manage_posts', 'an_admin_posts_filter_restrict_manage_posts' );

function an_admin_posts_filter_restrict_manage_posts(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
        $values = array(
            'Premium' => 'premium', 
            'Standard' => 'standard',
        );
        ?>
        <select name="role_filter">
        <option value="">Role</option>
        <?php
            $current_v = isset($_GET['role_filter'])? $_GET['role_filter']:'';
            foreach ($values as $label => $value) {
                printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_v? ' selected="selected"':'',
                        $label
                    );
                }
        ?>
        </select>
        <?php
}


add_filter( 'parse_query', 'an_posts_filter' );


function an_posts_filter( $query ){
    global $pagenow;
    
    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['role_filter']) && $_GET['role_filter'] != '') {
        $query->query_vars['meta_key'] = 'usergroup';
        $query->query_vars['meta_value'] = $_GET['role_filter'];
    }
}

function add_post_columns($columns) {
    return array_merge($columns, 
              array('usergroup' => __('Role')));
}
add_filter('manage_posts_columns' , 'add_post_columns');


function an_get_group_value($post_ID) {  
    $group_value = get_post_meta($post_ID, 'usergroup', true);  
    return $group_value;
} 


function an_columns_content($column_name, $post_ID) {  
    if ($column_name == 'usergroup') {  
            $group_value = an_get_group_value($post_ID);
            echo ucfirst($group_value);
    }  
}  
add_action('manage_posts_custom_column', 'an_columns_content', 10, 2);  
?>
