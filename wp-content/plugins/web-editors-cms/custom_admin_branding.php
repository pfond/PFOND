<?php
/**
* Some Branding in the admin header/footer
*/
function WE_custom_admin_branding() {
?>
    <style>
    #header-logo { background-image:none; }
    h1#site-heading { border:0px solid #fff; }
    /*  #site-title { font-size:12px; padding-left:20px; vertical-align: text-bottom; } */
    <?php if(get_option('wecms_hide_link')) { echo "\th1#site-heading { display:none; }"; } ?>
    footer-left { display:none; }
    .ozhmenu_toplevel ul { clear:both; }
    .ozhmenu_sublevel { clear:both; width:auto; }
    </style>
    <script type="text/javascript">
        document.getElementById('header-logo').src='<?php echo get_option('wecms_admin_logo') ?>';
        document.getElementById('header-logo').width='<?php echo get_option('wecms_admin_logo_width') ?>';
        document.getElementById('header-logo').height='16';
        document.getElementById('footer-left').innerHTML = '<?php echo get_option('wecms_footer_info'); ?>';
    </script>
<?php
}
add_action('admin_footer', 'WE_custom_admin_branding');
