<?php
/********************************************************************\
*** IF YOU HAVE A CUSTOM URL STRUCTURE TO SUPER CAPTCHA OR         *** 
*** WORDPRESS YOU MUST SPECIFY IT IN THIS FILE!                    ***
\********************************************************************/

define('PATH_TO_SCAPTCHA', '/wp-content/plugins/super-capcha'); 

// The above is the default and works under most installs, however if
// you have changed where the /wp-content/ folder or /plugins/ folder
// is located, you will have to tell SCAPTCHA where so it can be 
// specified when calling the image.