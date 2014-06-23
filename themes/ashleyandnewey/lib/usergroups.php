<?php

add_role('standard', 'Standard', array('read' => true));
add_role('premium', 'Premium', array('read' => true));


add_action('add_meta_boxes', 'an_add_custom_box');
add_action('save_post', 'an_implement_save_postdata');

function an_add_custom_box() {
    add_meta_box(
            'role', 'Role', 'an_implement_inner_custom_box', 'post', 'side', 'high'
    );
}

function an_implement_inner_custom_box() {

    global $post; 
    $postid = $post->ID;
    $roles = get_editable_roles();
    echo "<select id=\"usergroup_select\" name=\"usergroup_select\">";
    $group_value = get_post_meta($postid, 'usergroup', true);
    if (empty($group_value) || $group_value == "") {
        echo "<option value=\"\">— Choose —</option>";
        echo "<option value=\"premium\">" . $roles['premium']['name'] . "</option>
              <option value=\"standard\">" . $roles['standard']['name'] . "</option>";
    } else {

        echo "<option value=\"" . $group_value . "\">" . $roles[$group_value]['name'] . "</option>";
        if ($group_value == "standard") {
            echo "<option value=\"premium\">" . $roles['premium']['name'] . "</option>";
        } else {
            echo "<option value=\"standard\">" . $roles['standard']['name'] . "</option>";
        }
    }

    print_r($group_value);
    echo "</select>";
}

function an_implement_save_postdata($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id))
            return $post_id;
    }
    $usergroup = sanitize_text_field($_POST['usergroup_select']);
    update_post_meta($post_id, 'usergroup', $usergroup);
}

?>
