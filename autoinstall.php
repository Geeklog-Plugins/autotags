<?php

/**
* Autoinstall API functions for the Polls plugin
*
* @package Polls
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_autotags($pi_name)
{
    $pi_name         = 'autotags';
    $pi_display_name = 'Autotags';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '1.1.0',
        'pi_gl_version'   => '1.8.0',
        'pi_homepage'     => 'http://www.geeklog.net/'
    );

    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        $pi_name . '.edit'      => 'Access to ' . $pi_name . ' editor',
        $pi_name . '.PHP'       => 'Ability to create Autotags which use a PHP function', 
        'config.' . $pi_name . '.tab_main'                  => 'Access to configure general autotag settings',
        'config.' . $pi_name . '.tab_autotag_permissions'   => 'Access to configure default autotag usage permissions'        
    );

    $mappings = array(
        $pi_name . '.edit'      => array($pi_admin),
        'config.' . $pi_name . '.tab_main'                  => array($pi_admin),
        'config.' . $pi_name . '.tab_autotag_permissions'   => array($pi_admin)        
    );

    $tables = array(
        'autotags'
    );
    
    $requires = array(
        array(
               'db' => 'mysql',
               'version' => '4.1'
             )
    );
    

    $inst_parms = array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings,
        'tables'    => $tables,
        'requires'  => $requires
    );

    return $inst_parms;
}

/**
* Load plugin configuration from database
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true on success, otherwise false
* @see      plugin_initconfig_polls
*
*/
function plugin_load_configuration_autotags($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_autotags();
}

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*
*/
function plugin_compatible_with_this_version_autotags($pi_name)
{
    global $_CONF, $_DB_dbms;

    // check if we support the DBMS the site is running on
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
            . $_DB_dbms . '_install.php';
    if (! file_exists($dbFile)) {
        return false;
    }

    if (! function_exists('SEC_getGroupDropdown')) {
        return false;
    }

    if (! function_exists('SEC_createToken')) {
        return false;
    }

    if (! function_exists('COM_showMessageText')) {
        return false;
    }

    if (! function_exists('SEC_getTokenExpiryNotice')) {
        return false;
    }

    if (! function_exists('SEC_loginRequiredForm')) {
        return false;
    }

    return true;
}

?>
