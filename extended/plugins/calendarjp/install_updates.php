<?php

function calendarjp_update_ConfValues_1_1_1()
{
    global $_CONF, $_CAJP_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $c->add('addeventloginrequired', $_CAJP_DEFAULT['addeventloginrequired'], 'select', 0, 0, 0, 15, true, 'calendarjp');

    return true;
}

function calendarjp_update_ConfValues_1_1_2()
{
    global $_CONF, $_CAJP_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $c->add('wikitext_editor', $_CAJP_DEFAULT['wikitext_editor'], 'select', 0, 0, 1, 125, true, 'calendarjp');

    return true;
}

function calendarjp_update_ConfValues_1_1_4()
{
    global $_CONF, $_CAJP_DEFAULT, $_CAJP_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/calendarjp/install_defaults.php';

    // Autotag Usuage Defaults
    $c->add('fs_autotag_permissions', NULL, 'fieldset',
            0, 10, NULL, 0, true, 'calendarjp', 10);
    $c->add('autotag_permissions_event', $_CAJP_DEFAULT['autotag_permissions_event'], '@select',
            0, 10, 13, 10, true, 'calendarjp', 10);

    // Add in all the New Tabs
    $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'calendarjp', 0);
    $c->add('tab_permissions', NULL, 'tab', 0, 1, NULL, 0, true, 'calendarjp', 1);
    $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'calendarjp', 10);

    return true;
}

function calendarjp_update_ConfValues_1_1_5()
{
    global $_CONF, $_CAJP_DEFAULT, $_CAJP_CONF, $_GROUPS, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/calendarjp/install_defaults.php';

    $c->add('tab_events_block', NULL, 'tab', 0, 20, NULL, 0, true, 'calendarjp', 20);
    $c->add('fs_block_settings', NULL, 'fieldset', 0, 10, NULL, 0, true, 'calendarjp', 20);
    $c->add('block_enable', $_CAJP_DEFAULT['block_enable'], 'select',
            0, 10, 0, 10, true, 'calendarjp', 20);
    $c->add('block_isleft', $_CAJP_DEFAULT['block_isleft'], 'select',
            0, 10, 0, 20, true, 'calendarjp', 20);
    $c->add('block_order', $_CAJP_DEFAULT['block_order'], 'text',
            0, 10, 0, 30, true, 'calendarjp', 20);
    $c->add('block_topic_option', $_CAJP_DEFAULT['block_topic_option'],'select',
            0, 10, 15, 40, true, 'calendarjp', 20);
    $c->add('block_topic', $_CAJP_DEFAULT['block_topic'], '%select',
            0, 10, NULL, 50, true, 'calendarjp', 20);

    $c->add('fs_block_permissions', NULL, 'fieldset', 0, 20, NULL, 0, true, 'calendarjp', 20);
    $new_group_id = 0;
    if (isset($_GROUPS['Calendarjp Admin'])) {
        $new_group_id = $_GROUPS['Calendarjp Admin'];
    } else {
        $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Calendarjp Admin'");
        if ($new_group_id == 0) {
            if (isset($_GROUPS['Root'])) {
                $new_group_id = $_GROUPS['Root'];
            } else {
                $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
            }
        }
    }
    $c->add('block_group_id', $new_group_id,'select',
            0, 20, NULL, 10, TRUE, 'calendarjp', 20);
    $c->add('block_permissions', $_CAJP_DEFAULT['block_permissions'], '@select',
            0, 20, 14, 20, true, 'calendarjp', 20);

    return true;
}

?>