<?php

/**
* MySQL updates
*
* @package Autotags
*/
$DEFVALUES[] = "INSERT INTO {$_TABLES['autotags']} (tag, is_enabled, is_function, description, replacement) VALUES ('poll', 0, 0, 'Provides a link to the results of a poll: [poll:poll_id Link text]', '<a href=\"#U/polls/index.php?qid=#1&aid=-1\">#2</a>');";
$_UPDATES = array(

    '1.02' => array(
        "RENAME TABLE " . $_DB_table_prefix . "autotags_plg  TO {$_TABLES['autotags']}",
        
        "UPDATE {$_TABLES['features']} SET ft_name = 'autotags.edit' WHERE ft_name = 'autotags.admin'",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.autotags.tab_main', 'Access to configure general autotag settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.autotags.tab_autotag_permissions', 'Access to configure default autotag usage permissions', 0)",
        
        "DELETE FROM {$_TABLES['autotags']} WHERE tag = 'poll'", 
        "ALTER TABLE {$_TABLES['autotags']} ADD owner_id mediumint(8) NOT NULL default 2 AFTER replacement",
        "ALTER TABLE {$_TABLES['autotags']} ADD group_id mediumint(8) NOT NULL default 1 AFTER owner_id",
        "ALTER TABLE {$_TABLES['autotags']} ADD perm_owner tinyint(1) unsigned NOT NULL default 2 AFTER group_id",
        "ALTER TABLE {$_TABLES['autotags']} ADD perm_group tinyint(1) unsigned NOT NULL default 2 AFTER perm_owner",
        "ALTER TABLE {$_TABLES['autotags']} ADD perm_members tinyint(1) unsigned NOT NULL default 2 AFTER perm_group",
        "ALTER TABLE {$_TABLES['autotags']} ADD perm_anon tinyint(1) unsigned NOT NULL default 2 AFTER perm_members"
    )
    
);

/**
 * Add is new security rights for the Group "Autotags Admin"
 *
 */
function autotags_update_ConfigSecurity_1_0_2()
{
    global $_TABLES;
    
    // Add in security rights for Autotags Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Autotags Admin'");

    if ($group_id > 0) {
        $ft_names[] = 'config.autotags.tab_main';
        $ft_names[] = 'config.autotags.tab_autotag_permissions';
        
        foreach ($ft_names as $name) {
            $ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$name'");         
            if ($ft_id > 0) {
                $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $group_id)";
                DB_query($sql);
            }
        }        
    }    

}

?>
