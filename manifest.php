<?php
$manifest = array(
  'key' => '1902650d-9f67-4c95-a00d-21385cc25341',
  'name' => 'Config Manager',
  'description' => 'Search/Update Runtime Configuration',
  'author' => 'Seven Tunes Labs',
  'version' => '1.0',
  'is_uninstallable' => true,
  'published_date' => '08/08/2020 14:15:12',
  'type' => 'module',
  'acceptable_sugar_versions' =>
  array(
    'regex_matches' => array(
        '6.*',
        '7.*',
        '8.*',
        '9.*',
        '10.*'
    ),
  ),
  'acceptable_sugar_flavors' =>
  array(
    'PRO',
    'ENT',
    'ULT'
  ),
  'readme' => 'README.md',
  'icon' => 'seventunes.ico',
  'remove_tables' => '',
  'uninstall_before_upgrade' => false,
);

$installdefs = array(
    'id' => 'config_manager',
    'copy' => array(
        array(
            'from' => '<basepath>/files/ConfigManager.php',
            'to' => 'custom/modules/Administration/ConfigManager.php'
        ),
        array(
            'from' => '<basepath>/files/ConfigManager.tpl',
            'to' => 'custom/modules/Administration/ConfigManager.tpl'
        ),
    ),
    'administration' => array(
        array(
            'from' => '<basepath>/files/ConfigManagerAdminLink.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Administration/ConfigManagerAdminLink.php'
        ),
    ),
    'language' => array(
        array(
            'from' => '<basepath>/files/en_us.ConfigManager.php',
            'to' => 'custom/Extensions/modules/Administration/Ext/Language/en_us.ConfigManager.php',
            'to_module' => 'Administration',
            'language' => 'en_us'
        )
    )
);
