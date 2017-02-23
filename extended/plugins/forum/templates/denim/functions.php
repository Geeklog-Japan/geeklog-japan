<?php

// Allows plugin to add extra css and javascript libraries for individual themes.
// Theme settings will overwrite any plugin settimgs that are the same name/file


// this file can't be used on its own (keep this in as plugin template files could be located with theme) 
if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.php') !== false) {
    die('This file can not be used on its own!');
}


/**
 * Return an array of CSS files to be loaded
 */
function forum_css_denim()
{
    global $_CONF, $LANG_DIRECTION;

    $direction = ($LANG_DIRECTION == 'rtl') ? '_rtl' : '';

    return array(
        array(
            'name'       => 'uikit',
            'file'       => '/vendor/uikit/css' . $direction . '/uikit.gradient.min.css',
            'attributes' => array('media' => 'all'),
            'priority'   => 80
        ),
        
        array(
            'name'       => 'uikit-tooltip',
            'file'       => '/vendor/uikit/css' . $direction . '/components/tooltip.gradient.min.css',
            'attributes' => array('media' => 'all'),
            'priority'   => 70
        ),        

        array(
            'name'       => 'main', // don't use the name 'theme' to control the priority
            'file'       => '/layout/' . $_CONF['theme'] . '/css_' . $LANG_DIRECTION . '/style.css', // change '/style.css' during debugging
            'attributes' => array('media' => 'all')
        )
    );
}

/**
 * Return an array of JS libraries to be loaded
 */
function forum_js_libs_denim()
{
    return array(
       array(
            'library' => 'jquery',
            'footer'  => false // Not requred, default = true
        )
    );
}

/**
 * Return an array of JS files to be loaded
 */
function forum_js_files_denim()
{
    global $_CONF;

    return array(

       array(
            'file'      => '/vendor/uikit/js/uikit.js',
            'footer'    => false, // Not requred, default = true
            'priority'  => 100 // Not requred, default = 100
        ),
       
       array(
            'file'      => '/vendor/uikit/js/components/tooltip.js',
            'footer'    => false, // Not requred, default = true
            'priority'  => 110 // Not requred, default = 100
        ),       

       array(
            'file'      => '/layout/' . $_CONF['theme'] . '/javascript/script.js',
            'footer'    => true, // Not requred, default = true
            'priority'  => 100 // Not requred, default = 100
        )
    );
}

?>
