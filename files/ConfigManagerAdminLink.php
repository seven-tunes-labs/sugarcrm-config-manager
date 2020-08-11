<?php
$admin_option_defs = array();
$admin_option_defs['Administration']['ConfigManager'] = array(
    'Administration',
    'LBL_CONFIG_MANAGER', //Link title
    'LBL_CONFIG_MANAGER_DESCRIPTION', //Link Description
    './index.php?module=Administration&action=ConfigManager'
);
$admin_group_header[] = array(
    'LBL_RUNTIME_CONFIGURATION',
    '',
    false,
    $admin_option_defs,
    'LBL_RUNTIME_CONFIGURATION_DESCRIPTION' //Description of tab
);
