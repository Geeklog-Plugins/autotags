<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Autotags Plugin 1.0                                                       |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// +---------------------------------------------------------------------------+
// | Autotags Plugin Copyright (C) 2006 by the following authors:              |
// |          Joe Mucchiello    - jmucchiello AT yahoo DOT com                 |
// +---------------------------------------------------------------------------+
// | Based on the Universal Plugin and prior work by the following authors:    |
// |                                                                           |
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//

/**
* Implementation of the Plugin API for the Autotags plugin
*
* @package Autotags
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

$plugin_path = $_CONF['path'] . 'plugins/autotags/';

/**
* Language file include
*/
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}

$langfile = $_CONF['path'] . 'plugins/autotags/language/'
          . $_CONF['language'] . '.php';

/**
* Check and see if we need to load the plugin configuration
*/
if (!isset($_AUTO_CONF['link_in_menu'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $auto_config = config::get_instance();
    $_AUTO_CONF = $auto_config->get_config('autotags');

}

/**
 * Autotags plugin table(s)
 */
global $_DB_table_prefix;
$_TABLES['autotags']  = $_DB_table_prefix . 'autotags';


$_AUTOTAGS = Array();
/*
 *  Populates the $_AUTOTAGS global array with list of enabled
 *  autotags. Does not contain autotags from other plugins.
 *
 *  When autotags are in use, they can generate a lot of little calls
 *  to the DB server. This array is hopefully faster. It certainly is
 *  easier to code array accesses than DB accesses.
 */
function loadAutotags()
{
    global $_TABLES, $_AUTOTAGS, $_AUTO_CONF;

    if (isset($_AUTO_CONF['loaded']) && $_AUTO_CONF['loaded'] == 1)
        return;

    $pi_enabled = DB_getItem($_TABLES['plugins'], 'pi_enabled', "pi_name = 'autotags'");
    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'autotags'");
    $code_version = plugin_chkVersion_autotags();
    if ($pi_enabled && ($installed_version == $code_version)) { // Needed to double check incase of uninstall
        $sql = "SELECT * FROM {$_TABLES['autotags']} WHERE is_enabled = 1";
        $result = DB_query($sql);
        $num = DB_numrows($result);
        for ($i = 0; $i < $num; ++$i)
        {
            $A = DB_fetchArray($result);
            // Only include tag if not a function or if a function and php is allowed
            if ($A['is_function'] == 0 || ($_AUTO_CONF['allow_php'] == 1 && $A['is_function'] == 1)) {
                $_AUTOTAGS[$A['tag']] = $A;
            }
        }
        $_AUTO_CONF['loaded'] = 1;

    }
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Return the current version of code.
* Used in the Plugin Editor to show the registered version and code version
*/
function plugin_chkVersion_autotags()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/autotags/autoinstall.php';

    $inst_parms = plugin_autoinstall_autotags('autotags');

    return $inst_parms['info']['pi_version'];
}

/**
* Update the Autotags plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function plugin_upgrade_autotags()
{
    global $_CONF, $_TABLES, $_DB_dbms, $_DB_table_prefix; //prefix needed for 1.10 upgrade

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'autotags'");
    $code_version = plugin_chkVersion_autotags();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/autotags/autoinstall.php';

    if (! plugin_compatible_with_this_version_autotags('autotags')) {
        return 3002;
    }

    // Retrieve other plugin info like min geeklog version and homepage
    $inst_parms = plugin_autoinstall_autotags('autotags');

    require_once $_CONF['path'] . 'plugins/autotags/sql/'
                                . $_DB_dbms . '_updates.php';

    require_once $_CONF['path'] . 'plugins/autotags/install_updates.php';

    $current_version = $installed_version;
    $done = false;
    while (! $done) {
        switch ($current_version) {
        case '1.0':
            $current_version = '1.01';
            break;

        case '1.01':

            if (!DB_getItem($_TABLES['autotags'], '1', "tag = 'lang'")) {
                DB_query("INSERT INTO {$_TABLES['autotags']} (tag, is_enabled, is_function, description, replacement) VALUES ('lang', 0, 1, 'Provides access to the $LANG family of variables', NULL)");
            }

            $current_version = '1.02';
            break;

        case '1.02':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }

            autotags_update_ConfValues_1_0_2();
            autotags_update_ConfigSecurity_1_0_2();

            $current_version = '1.1.0';
            break;

        case '1.1.0':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }

            $current_version = '1.1.1';
            break;

        case '1.1.1':

            $current_version = '1.1.2';
            break;

        case '1.1.2':

            $current_version = '1.1.3';
            break;
        
		case '1.1.3':

            $current_version = '1.1.4';
            break;

        default:
            $done = true;
        }
    }

    // update plugin version number and other info
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '{$inst_parms['info']['pi_gl_version']}', pi_homepage = '{$inst_parms['info']['pi_homepage']}' WHERE pi_name = 'autotags'");

    COM_errorLog( "Updated autotags plugin from v$installed_version to v$code_version", 1 );

    return true;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function plugin_autouninstall_autotags ()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('autotags'),
        /* give the full name of the group, as in the db */
        'groups' => array('Autotags Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('autotags.edit',
                            'autotags.PHP',
                            'config.autotags.tab_main',
                            'config.autotags.tab_autotag_permissions'),
        /* give all vars with their name */
        'vars'=> array()
    );
    return $out;
}

function plugin_commentsupport_autotags()
{
    return false;
}

function plugin_cclabel_autotags()
{
    global $_CONF;

    if (SEC_hasRights ('autotags.edit')) {
        return array('Autotags',
                $_CONF['site_admin_url'] . '/plugins/autotags/index.php',
                plugin_geticon_autotags ());
    }

    return false;
}

function plugin_getadminoption_autotags()
{
    global $_CONF, $_TABLES;

    if (SEC_hasRights ('autotags.edit')) {
        $result = DB_query ("SELECT count(*) AS cnt FROM {$_TABLES['autotags']}");
        $A = DB_fetchArray ($result);
        $total_pages = $A['cnt'];
        return array('Autotags', $_CONF['site_admin_url'] . '/plugins/autotags/index.php', $total_pages);
    }
}

function plugin_getmenuitems_autotags()
{
    global $_CONF, $_AUTO_CONF, $LANG_AUTO;

    $menuitems = array();

    if ($_AUTO_CONF['link_in_menu'] == 1)
    {
        $menulabel = $LANG_AUTO['main_menulabel'];
        $menuurl = $_CONF['site_url'] . "/autotags/index.php";

        $menuitems["$menulabel"] = $menuurl;
    }
    return $menuitems;
}

function plugin_geticon_autotags ()
{
    global $_CONF;

    return $_CONF['site_admin_url'] . '/plugins/autotags/images/autotags.png';
}

function plugin_getListField_autotags($fieldname, $fieldvalue, $A, $icon_arr) {
    global $_CONF, $_AUTO_CONF, $LANG_ACCESS;

    switch($fieldname) {
        case "edit":
            if ($A['is_function'] && (!SEC_hasRights('autotags.PHP') || $_AUTO_CONF['allow_php'] == 0))
                $retval = '';
            else
                $retval = "<a href=\"{$_CONF['site_admin_url']}/plugins/autotags/index.php?mode=edit&amp;tag={$A['tag']}\">{$icon_arr['edit']}</a>";
            break;
        case "tag":
            $retval = $A['tag'];
            break;
        case "description":
            $retval = stripslashes ($A['description']);
            break;
        case 'is_function':
            $retval = ($A['is_function'] == 1) ? $LANG_ACCESS['yes'] : $LANG_ACCESS['no'];
            break;
        case 'is_enabled':
            if ($A['is_function'] && (!SEC_hasRights('autotags.PHP') || $_AUTO_CONF['allow_php'] == 0))
            {
                $retval = ($A['is_enabled'] == 1) ? $LANG_ACCESS['yes'] : $LANG_ACCESS['no'];
            } else {
                $switch = ($A['is_enabled'] == 1) ? 'checked="checked"' : '';
                if (COM_versionCompare(VERSION, '2.2.0', '>=')) {
                    $retval = COM_createControl('type-checkbox', array(
                        'name' => 'enabledtags[]',
                        'onclick' => 'this.form.submit()',
                        'value' => $A['tag'],
                        'checked' => $switch
                    ));
                    $retval .= '<input type="hidden" name="visibletags[]" value="' . $A['tag'] . '"' . XHTML . '>';
                } else {
                    $retval = '<input type="checkbox" name="enabledtags[]" '
                                . 'onclick="submit()" value="' . $A['tag'] . '"'
                                . $switch . XHTML . '>'
                                . '<input type="hidden" name="visibletags[]" value="'
                                . $A['tag'] . '"' . XHTML . '>';
                }
            }
            break;
        default:
            $retval = $fieldvalue;
            break;
    }
    return $retval;
}

/**
* Why we are here.
*
*/
function plugin_autotags_autotags($op, $content = '', $autotag = '', $parameters = array())
{
    global $_CONF, $_TABLES, $_AUTOTAGS, $LANG01;

    loadAutotags();

    if ($op == 'tagname' ) {
        return array_keys($_AUTOTAGS);
    } elseif ($op == 'permission' || $op == 'nopermission') {
        if ($op == 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }

        foreach ($_AUTOTAGS as $tag) {
            if (COM_getPermTag($tag['owner_id'], $tag['group_id'], $tag['perm_owner'], $tag['perm_group'], $tag['perm_members'], $tag['perm_anon']) == $flag) {
                $tagname[] = $tag['tag'];
            }
        }

        if (isset($tagname) && is_array($tagname)) {
            return $tagname;
        }
    } elseif ($op == 'closetag') {
        foreach ($_AUTOTAGS as $tag) {
            if (isset($tag['close_tag']) && $tag['close_tag']) {
                $closetag[] = $tag['tag'];
            }
        }

        if (isset($closetag) && is_array($closetag)) {
            return $closetag;
        }
    } elseif ($op == 'description') {
		$autotag_desc = array();

        foreach ($_AUTOTAGS as $tag) {
            $autotag_desc[$tag['tag']] = $tag['description'];
        }

        if (count($autotag_desc) > 0) {
            return $autotag_desc;
        }
    } else if ($op == 'parse') {
        // [tag:parameter1 And the rest here is parameter2]This is parameter3 if exist.[/tag]
        $p1 = $autotag['parm1'];
        $p2 = $autotag['parm2'];
        if (isset($autotag['parm3'])) {
            $p3 = $autotag['parm3'];
        }

        // See if calling plugin info exists
        // Lets use it in just php stuff
        if (isset($parameters['type']) && isset($parameters['id'])) {
            $type = $parameters['type'];
            $id = $parameters['id'];
        }  else {
            $type = '';
            $id = '';
        }

        if (empty($p2)) $p2 = $p1;

        if (isset($_AUTOTAGS[$autotag['tag']]))
        {
            $record = $_AUTOTAGS[$autotag['tag']];
            if ($record['is_function'] == 1)
            {
                if (empty($record['replacement'])) {
                    $function = 'phpautotags_'.$autotag['tag'];
                    if (function_exists($function))
                    {
                        $reffunc = new ReflectionFunction($function);
                        if (isset($p3) && $reffunc->getNumberOfParameters() >= 6) {
                            $replace = $function($p1, $p2, $autotag['tagstr'], $p3, $type, $id);
                        } else {
                            $replace = $function($p1, $p2, $autotag['tagstr'], $type, $id);
                        }

                        $content = str_replace($autotag['tagstr'], $replace, $content);
                    }
                } else {
                    $evalstring = '$p1 = "' . $p1 . '";';
                    // $p2 could have ' or " in it so addslashes to get variable in evaluate and then remove right after so doesn't change anything else
                    $evalstring .= '$p2 = "' . addslashes($p2) . '";';
                    $evalstring .= '$p2 = stripslashes($p2);';
                    if (isset($p3)) {
                        // $p3 could have ' in it so addslashes to get variable in evaluate and then remove right after so doesn't change anything else
                        $evalstring .= '$p3 = "' . addslashes($p3) . '";';
                        $evalstring .= '$p3 = stripslashes($p3);';
                    }
                    $evalstring .= '$tagstr = "' . addslashes($autotag['tagstr']) . '";';
                    $evalstring .= '$tagstr = stripslashes($tagstr);';
                    $evalstring .= '$type = "' . $type . '";';
                    $evalstring .= '$id = "' . $id . '";';
                    $evalstring .= $record['replacement'];
                    //$replace = eval($evalstring);

                    // Lets try to error gracefully if we need too when evaluating PHP
                    // Cannot use COM_handleEval as that is an outside function as the code we need to evaluate contains references to variables here
                    if (version_compare(PHP_VERSION, '7.0.0', '<')) {
                        $str = eval($evalstring);

                        if ($str === false) {
                            $errorMessage = $LANG01[144];
                        }
                    } else {
                        try {
                            $str = eval($evalstring);
                        } catch (ParseError $e) {
                            COM_errorLog(__FUNCTION__ . ': ' . $e->getMessage());
                            $errorMessage = $LANG01[144];
                        }
                    }
                    $replace = empty($errorMessage) ? $str : $errorMessage;

                    $content = str_replace($autotag['tagstr'], $replace, $content);
                }
            } else {
                $p0 = substr($autotag['tagstr'], strlen($autotag['tag']) + 2);
                $p0 = substr($p0, 0, strlen($p0)-1);

                if (isset($p3)) {
                    $replace = Array('#U', '#1', '#2', '#0', '#3');
                    $with = Array($_CONF['site_url'], $p1, $p2, $p0, $p3);
                } else {
                    $replace = Array('#U', '#1', '#2', '#0');
                    $with = Array($_CONF['site_url'], $p1, $p2, $p0);
                }

                $subject = $record['replacement'];
                $subject = str_replace($replace, $with, $subject);
                $content = str_replace($autotag['tagstr'], $subject, $content, $count);
            }
        }
        return $content;
    }
}


/*
 *  Sample function-based autotags. These functions are only available
 *  if $_AUTO_CONF['allow_php'] == 1 and the administrator possesses the
 *  autotags.PHP feature. They are disabled by default.
 *
 */

function phpautotags_topic($p1, $p2, $fulltag)
{
    global $_TABLES, $_CONF;

    $topic = DB_getItem($_TABLES['topics'], 'topic', "tid = '$p1'" . COM_getTopicSQL('AND'));
    // Comment out the line above and uncomment the line below if you
    // don't care whether or not users can see the names of topic they
    // cannot access.
//    $topic = DB_getItem($_TABLES['topics'], 'topic', "tid = '$p1'");

    if (empty($topic))
        return "<B>Unknown Topic</B>";
    $topic = stripslashes($topic);
		return "<a href=\"{$_CONF['site_url']}/index.php?topic=".urlencode($p1)."\">".htmlspecialchars($topic)."</a>";

}

function phpautotags_cipher($p1, $p2, $fulltag)
{
    $code = "abcdefghijklmnopqrstuvwxyz";
    $key = Array();
    $len = strlen($p1);
    for ($i = 0; $i < $len; ++$i)
        $key[$p1[$i]] = $code[$i];

    $result = '';
    $len = strlen($p2);
    for ($i = 0; $i < $len; ++$i)
    {
        $c = strtolower($p2[$i]);
        $upper = $c != $p2[$i];
        if (!isset($key[$c]))
            $result .= $p2[$i];
        else if ($upper)
            $result .= strtoupper($key[$c]);
        else
            $result .= $key[$c];
    }
    return $result;
}

function phpautotags_lang($p1, $p2, $fulltag)
{
    if (empty($p1) || empty($p2)) {
        return '';
    }

    $lang = "LANG$p1";
    if (!is_array($GLOBALS[$lang])) {
        $lang = "LANG_$p1";
    }
    if (is_array($GLOBALS[$lang]) && isset($GLOBALS[$lang][$p2])) {
        return $GLOBALS[$lang][$p2];
    }
    return '{$LANG'.$p1.'['.$p2.']}';
}

?>
