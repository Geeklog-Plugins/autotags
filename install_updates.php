<?php

function autotags_update_ConfValues_1_0_2()
{
    global $_CONF, $_AUTO_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $_CONF['path'] . 'plugins/autotags/install_defaults.php';
    
    $c = config::get_instance();

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

    return true;
}

?>