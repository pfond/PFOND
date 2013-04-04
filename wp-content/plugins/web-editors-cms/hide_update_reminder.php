<?php
//remove the update reminder
function WE_remove_nag() {
echo '
<style type="text/css">
    #update-nag { display: none; }
</style>
';
}
//check users levek
function WE_check_userlevel() {
    global $userdata;
    if ($userdata->user_level < 10) :
        add_action('admin_head', 'WE_remove_nag');
    endif;
}
add_action('admin_init', 'WE_check_userlevel');
?>