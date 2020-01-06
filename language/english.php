<?php

###############################################################################
# english.php
# This is the english language page for the Geeklog Autotags Plug-in!
#
# Copyright (C) 2006 Joe Mucchiello
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################


$LANG_AUTO = array(
    'newpage' => 'New Page',
    'adminhome' => 'Admin Home',
    'tag' => 'Tag',
    'autotag' => 'Autotag',
    'desc' => 'Description',
    'replacement' => 'Replace With',
    'enabled' => 'Enabled?',
    'close_tag' => 'Requires Close Tag?',
    'function' => 'Replace with PHP?',
    'short_function' => 'Is Function?',
    'autotagseditor' => 'Autotags Editor',
    'autotagsmanager' => 'Autotags Manager',
    'list_of_autotags' => 'List of Autotags',
    'edit' => 'Edit',
    'save' => 'save',
    'delete' => 'delete',
    'cancel' => 'cancel',

    'access_denied' => 'Access Denied',
    'access_denied_msg' => 'You are illegally trying access one of the Autotags administration pages.  Please note that all attempts to illegally access this page are logged',
    'deny_msg' => 'Access to this page is denied.  Either the page has been moved/removed or you do not have sufficient permissions.',

    'php_msg_enabled' => '<p>If you just check the PHP checkbox, when this tag is encountered the function named with the tag\'s name prefixed with phpautotags_ will be called to translate the tag. So for example your php function would be defined as :</p>

        <p><b>phpautotags_yourtagname($p1, $p2, $autotag[\'tagstr\'], $p3, $type, $id)</b></p>
        <p>Note: The $p3 variable is only passed if the close tag is enabled.</p>
        <p>If the PHP checkbox is checked and the  <b>Replace With</b> field contains text then the text will be evaluated as PHP. To access the first parameter reference the $p1 variable, for the second parameter you would reference $p2, and for the third parameter you would reference $p3 in your PHP script.</p>
        <p>The $type parameter is the name of the plugin that the autotag was called from and the $id paramter is the id of the item for the plugin that autotag was in. These 2 parameters are supported by Articles and Static Pages. If a plugin does not support these 2 parameters then they will contain an empty string.</p>
        <p>The variable $tagstr will contain the entire string. Use return in your PHP script to return the text you want to replace the autotag with.',
    'php_msg_disabled' => 'You must set the Allow PHP configuration setting to true in the Geeklog Configuration panel and be in a group with the autotags.PHP feature in order to modify autotags that call a function to translate the tag.',

    'disallowed_tag' => 'The tag you have chosen is restricted and not available for use. Choose another tag.',
    'duplicate_tag' => 'The tag you have chosen is already in use. Please choose another tag name or edit the existing tag.',
    'no_tag_or_replacement' => 'You must at least fill in the <b>Tag</b> and <b>Replace With</b> fields.',
    'invalid_tag' => 'The tag must contain only alphanumeric characters (a-z, A-Z, 0-9), dashes (-) or underscores (_).',

    'instructions' => 'To modify or delete an autotag, click on that tag\'s edit icon below. To create a new autotag, click on "Create New" above. <p>If there are tags you cannot edit or enable it is because these autotags are function based and you do not have access to the autotags.PHP feature or function based autotags are disabled in $_AUTO_CONF.',

    'replace_explain' => '<p>Autotags can take either form:</p>
        <ul>
            <li><b>[tag:parameter1 And the rest here is parameter2]</b></li>
            <li><b>[tag:parameter1 And the rest here is parameter2]This is parameter3 if exist.[/tag]</b></li>
        </ul>
        <p>In the replace with field you can type any valid HTML. You can include parameter1 and/or parameter2 and/or parameter3 (if it exists) in your replacement string by putting #1 and/or #2 and/or #3 in the Replace With field.</p>
        <p>In addition to #1, #2 and #3, #0 is the entire string after the first colon until the end of the tag (does not include #3). #U is the base url of the website.</p>
        <p>Example 1: Autotags are commonly used to create links. A Replace With field of <b>&lt;a href="http://path.to.somewhere/#1"&gt;#2&lt;/a&gt;</b> when combined with this tag <b>[tag:foo This is a link]</b> will result in the string <b>&lt;a href="http://path.to.somewhere/foo"&gt;This is a link&lt;/a&gt;</b></p>

        <p>Example 2 (with close tag): Autotags can be used to add HTML tags. A Replace With field of <b>&lt;#1&gt;#3&lt;/#1&gt;</b> when combined with this tag <b>[tag:h1]This is a Heading[/tag]</b> will result in the string <b>&lt;h1&gt;This is a Heading&lt;/h1&gt;</b></p>

        ',

    'php_not_activated' => 'The use of PHP in Autotags is not activated. Please see the configuration.',

    'edit' => 'Edit',

    'search' => 'Search',
    'submit' => 'Submit',

    'usagepermissionskey' => 'U = usage',

    'window_close' => 'Close',
    'main_menulabel' => 'Autotag List'
);

// Localization of the Admin Configuration UI
$LANG_configsections['autotags'] = array(
    'label' => 'Autotags',
    'title' => 'Autotags Configuration'
);

$LANG_confignames['autotags'] = array(
    'link_in_menu' => 'Enable Autotags Menu Entry?',
    'disallow' => 'Disallowed Autotag Names',
    'allow_php' => 'Allow PHP',
    'default_autotag_permissions' => 'Default Permissions'
);

$LANG_configsubgroups['autotags'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['autotags'] = array(
    'tab_main' => 'General Autotags Settings',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['autotags'] = array(
    'fs_main' => 'General Autotags Settings',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['autotags'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2)
);

?>
