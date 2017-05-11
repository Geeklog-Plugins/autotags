<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Autotags Plugin 1.01                                                      |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
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
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
// $Id: install.php,v 1.1 2005/11/13 13:46:06 dhaun Exp $

$_SQL[] = "
CREATE TABLE {$_TABLES['autotags']} (
  tag varchar(24) NOT NULL default '',
  description varchar(255) default '',
  is_enabled tinyint(1) NOT NULL default 0,
  is_function tinyint(1) NOT NULL default 0,
  close_tag tinyint(1) NOT NULL default 0,
  replacement text,
  owner_id mediumint(8) NOT NULL default 2,
  group_id mediumint(8) NOT NULL default 1,
  perm_owner tinyint(1) unsigned NOT NULL default 2,
  perm_group tinyint(1) unsigned NOT NULL default 2,
  perm_members tinyint(1) unsigned NOT NULL default 2,
  perm_anon tinyint(1) unsigned NOT NULL default 2,
  
  PRIMARY KEY  (tag)
) ENGINE=MyISAM
";

$DEFVALUES[] = "INSERT INTO {$_TABLES['autotags']} (tag, is_enabled, is_function, description, replacement) VALUES ('cipher', 0, 1, 'A simple substitution cipher. This is rot13: [cipher:nopqrstuvwxyzabcdefghijklm Text to encode]', NULL);";
$DEFVALUES[] = "INSERT INTO {$_TABLES['autotags']} (tag, is_enabled, is_function, description, replacement) VALUES ('topic', 0, 1, 'Provides a link to index.php with the specified topic: [topic:tid]', NULL);";
$DEFVALUES[] = "INSERT INTO {$_TABLES['autotags']} (tag, is_enabled, is_function, description, replacement) VALUES ('lang', 0, 1, 'Provides access to the LANG family of variables', NULL);";
$DEFVALUES[] = "INSERT INTO {$_TABLES['autotags']} (tag, is_enabled, is_function, close_tag, description, replacement) VALUES ('html', 0, 0, 1, 'Wraps text in specified HTML tags: [html:em]some text[/html]', '<#1>#3</#1>');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['autotags']} (tag, is_enabled, is_function, description, replacement) VALUES ('youtube', 0, 0, 'Embeds a youtube.com video: [youtube:video_id]', '<iframe width="560" height="315" src="https://www.youtube.com/embed/#1" frameborder="0" allowfullscreen></iframe>');";

?>