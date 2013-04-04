<?php
/**
* Change up the login page
*/
function WE_custom_login_logo() {
?>
<style type="text/css">
h1 a { background-image:url(<?php echo get_option('wecms_login_logo') ?>) !important; margin-bottom:5px; }
body { border-top-style:none; }
#backtoblog { display:none; }
</style>
<script type="text/javascript">
function WE_login() {
    var WEchangeLink = document.getElementById('login').innerHTML;
    WEchangeLink = WEchangeLink.replace("wordpress.org/", "<?php echo get_option('wecms_url_replace'); ?>");
    WEchangeLink = WEchangeLink.replace("Powered by WordPress", "<?php echo get_option('wecms_login_replace'); ?>");
    document.getElementById('login').innerHTML = WEchangeLink;
}
window.onload=WE_login;
</script>
<?php
}
add_action('login_head', 'WE_custom_login_logo');