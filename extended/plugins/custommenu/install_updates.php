<?php

function custommenu_update_ConfValues_0_5_0()
{
    global $_TABLES;

//    global $_CONF;
//    require_once $_CONF['path_system'] . 'classes/config.class.php';
    $c = config::get_instance();

    // Add in all the New Tabs
    $c->add('tab_main',        NULL, 'tab', 0, 0, NULL, 0, true, 'custommenu', 0);
    $c->add('tab_permissions', NULL, 'tab', 0, 2, NULL, 0, true, 'custommenu', 1);

    DB_query("UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'custommenu'");

    return true;
}

/**
 * Add is new security rights for the Group "CustomMenu Admin"
 *
 */
function custommenu_update_ConfigSecurity_0_5_0()
{
    global $_TABLES;

    // Add in security rights for CustomMenu Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'CustomMenu Admin'");

    if ($group_id > 0) {
        $ft_names[] = 'config.custommenu.tab_main';
        $ft_names[] = 'config.custommenu.tab_permissions';

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