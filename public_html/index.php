<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Autotags Geeklog Plugin 1.0                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is a simple end-user listing of all autotags in the system.          |
// +---------------------------------------------------------------------------+
// | Autotags Plugin Copyright (C) 2006 by the following authors:              |
// |          Joe Mucchiello    - jmucchiello AT yahoo DOT com                 |
// +---------------------------------------------------------------------------+
// | Based on the Universal Plugin and prior work by the following authors:    |
// |                                                                           |
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
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

require_once ('../lib-common.php');

/*
 *  Generates a list of all active autotags with description.
 */
function list_all_tags()
{
    global $_CONF, $LANG_AUTO;
    
    $autotags = PLG_collectTags('permission');
    $plugins_tags = PLG_collectTags();
    ksort($autotags);
    $autotags = array_keys($autotags);
    $description = array_flip(PLG_collectTags('description'));
    
    $at_template = COM_newTemplate(CTL_plugin_templatePath('autotags'));        
    $at_template->set_file('list', 'autotags_list.thtml');
    
    $blocks = array('autotag_row');
    foreach ($blocks as $block) {
        $at_template->set_block('list', $block);
    }    
    
    $at_template->set_var('lang_autotag', $LANG_AUTO['autotag']);
    $at_template->set_var('lang_desc', $LANG_AUTO['desc']);
        
    foreach ($autotags as $tag) {
        if ($description[$tag] != '') {
            $descr = $description[$tag];
        } else { // Permissions and Description not supported
            $descr = "Part of the " . $plugins_tags[$tag] . " plugin";
        }
        
        $at_template->set_var('tag', $tag);
        $at_template->set_var('descr', $descr);
        
        $at_template->parse('autotag_rows', 'autotag_row', true);
    }    
    
    $display = $at_template->parse('output','list');    
        
    return $display;    
}

$mode = Geeklog\Input::fRequest('mode', '');

$display = '';
if ($mode == 'popup') {
    // if you want to put the list of tags in a popup window, use
    // this mode.
    $display = '<html><body>'
                . '<div style="text-align:right"><a href="javascript:window.close()">'
                . $LANG_AUTO['window_close'] . '</a></div>';                
    $display .= list_all_tags();
    $display .= '</body></html>';
} else {
    $display .= COM_startBlock($LANG_AUTO['list_of_autotags']);
    $display .= list_all_tags();
    $display .= COM_endBlock();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_AUTO['list_of_autotags']));
}

COM_output($display);

?>