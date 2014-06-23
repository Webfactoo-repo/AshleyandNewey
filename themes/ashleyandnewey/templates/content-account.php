<?php
if (!is_user_logged_in()){
    ?>
    <script type="text/javascript">
        window.location= <?php echo "'" . home_url() . "'"; ?>;
    </script>
    <?php
} else {
    $user_info = get_userdata( $user_ID );

    get_template_part('templates/content', 'page-header');
    ?>
    <div id="account-page">

        <div class="title"><h2>Your account</h2></div>
        <form method="POST" action="" class="account-change">
            <div class="your-account">
                <table>
                    <tr>
                        <td class="r0" id="d0">Name</td>
                        <td class="r0" id="d1"><input type="text" name="name" value="<?php echo $user_info->first_name; ?>" readonly="readonly"></td>
                    </tr>
                    <tr>
                        <td class="r1" id="d0">Company</td>
                        <td class="r1" id="d1"><input type="text" name="company" value="<?php echo $user_info->last_name; ?>" readonly="readonly"></td>
                    </tr>
                    <tr>
                        <td class="r0" id="d0">Email</td>
                        <td class="r0" id="d1"><input type="text" name="email" value="<?php echo $user_info->user_email; ?>" readonly="readonly"></td>
                    </tr>
                    <tr>
                        <td class="r1" id="d0">Phone</td>
                        <td class="r1" id="d1"><input type="text" name="phone" value="<?php $url=$user_info->user_url; $url = str_replace('http://', '', $url); echo $url; ?>" readonly="readonly"></td>
                    </tr>
                    <tr>
                        <td class="r0" id="d0">Username</td>
                        <td class="r0" id="d1"><input type="text" name="username" value="<?php echo $user_info->user_login; ?>" readonly="readonly"></td>
                    </tr>
                    <tr>
                        <input type="hidden" name="userid" id="userid" value="<?php echo $user_ID ?>" />
                        <td class="r1" id="d0">New password</td>
                        <td class="r1" id="d1"><input type="password" name="newpassword"></td>
                    </tr>
                    <tr>
                        <td class="r0" id="d0">New password again</td>
                        <td class="r0" id="d1"><input type="password" name="newpassworda"></td>
                    </tr>
                </table>
            </div>
            <input type="submit" value="Save" class="button">
        </form>
        <div class="message"></div>
    </div>
<?php
}
?>