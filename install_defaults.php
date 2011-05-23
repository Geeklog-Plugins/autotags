<?php

/**
* Install data and defaults for the Autotags plugin configuration
*
* @package Autotags
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Autotags default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */
global $_AUTO_DEFAULT;
$_AUTO_DEFAULT = array();

/*
 *  Adds a link to top menu for access to the autotag link in
 *  /public_html/autotags/index.php
 *
 *  There is no other link to this page in the system. Working it into
 *  the submit screen or adding a block with a link to it is up to the
 *  site administrator.
 */
$_AUTO_DEFAULT['link_in_menu'] = 0;

/*
 *  Autotag editor will not allow any value in this array to be used as
 *  a tag. This array is merged with the existing list of autotags to
 *  determine whether or not a given autotag is already in use. You
 *  generally will not need to put anything into this list, but I'm sure
 *  someone will have a use for this.
 *
 *  This defaults to ('geeklog') because the builtin autotags for 'story'
 *  and 'event' claim to be in the 'geeklog' plugin.
 */
$_AUTO_DEFAULT['disallow'] = array('geeklog');

/*
 *  This is similar in function to the static page PHP functions. Access
 *  to executable code requires both this value to be 1 and that the
 *  user have access to the autotags.PHP feature which is NOT granted to
 *  Root by the installer.
 *
 *  Unlike static pages, the autotag callback function for function
 *  based tags has a fixed name in the format phpautotags_$tag. The
 *  parameters to these function are based on the standard autotag code.
 *  Autotags have the format
 *      [tag:parameter1 the remainderis parameter2]
 *  Thus the function specification
 *      phpautotags_$tag($p1, $p2, $fulltext)
 *  puts parameter1 into $p1, parameter2 into $p2 and all the text
 *  between the brackets (including the brackets) is put into $fulltext.
 */
$_AUTO_DEFAULT['allow_php'] = 0;

// Define default usuage permissions for the polls autotags.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 2 = use
// 0 = cannot use
// (a value of 1 is not allowed)
$_AUTO_DEFAULT['default_autotag_permissions'] = array (2, 2, 2, 2);


/**
* Initialize Autotags plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_AUTO_CONF if available (e.g. from
* an old config.php), uses $_AUTO_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_autotags()
{
    global $_CONF, $_AUTO_CONF, $_AUTO_DEFAULT;

    if (is_array($_AUTO_CONF) && (count($_AUTO_CONF) > 1)) {
        $_AUTO_DEFAULT = array_merge($_AUTO_DEFAULT, $_AUTO_CONF);
    }

    $c = config::get_instance();
    if (!$c->group_exists('autotags')) {
        
        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'autotags', 0);
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'autotags', 0, 0);
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'autotags', 0);
        $c->add('link_in_menu', $_AUTO_DEFAULT['link_in_menu'], 'select',
                0, 0, 1, 10, true, 'autotags', 0);
        $c->add('disallow',$_AUTO_DEFAULT['disallow'],'%text', 
                0, 0, 1, 20, true, 'autotags', 0);
        $c->add('allow_php', $_AUTO_DEFAULT['allow_php'], 'select',
                0, 0, 1, 30, true, 'autotags', 0);        

        $c->add('tab_autotag_permissions', NULL, 'tab', 0, 0, NULL, 0, true, 'autotags', 10);
        $c->add('fs_autotag_permissions', NULL, 'fieldset', 
                0, 10, NULL, 0, true, 'autotags', 10);
        $c->add('default_autotag_permissions', $_AUTO_DEFAULT['default_autotag_permissions'], '@select', 
                0, 10, 13, 10, true, 'autotags', 10); 
    }

    return true;
}

?>
