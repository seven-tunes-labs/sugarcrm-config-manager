<?php

/**
 * Used to do a quick update of Runtime Configuration
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


// =============================================================================

// TODO - Update the keywords you don't want to show in the UI
const CONFIG_KEYS_TO_MASK=['pass', 'key'];
const CONFIG_KEYS_TO_DENY_UPDATE=['pass', 'key', 'dbconfig'];

// This password is used to validate if the request is valid. Change it!
// This is just a basic check. Don't want to hardcode move it to sugar_config
const CONFIG_MANAGER_PASSWORD='DzhC5YZi9qEtfML2';


// =============================================================================


require_once 'include/SugarSmarty/plugins/function.sugar_csrf_form_token.php';

// Allow only admins, just in case
global $current_user, $db;
if(!$current_user->isAdmin()) {
    echo "Access Denied";
    return;
}


/**
 * Remove any keywords
 * @param $arr
 */
function removePasswordKeys(&$arr)
{
    if (!empty($arr) && is_array($arr)) {
        // Remove password references
        foreach ($arr as $key => &$value) {
            foreach (CONFIG_KEYS_TO_MASK as $skip) {
                if (strstr(strtolower($key), $skip)) {
                    $arr[$key] = '*******';
                }
            }

            if (is_array($value)) {
                removePasswordKeys($value);
            }
        }
    }
}

/**
 * Display the config from backend
 *
 * @param $path
 */
function displayConfig($path)
{
    $arr = retrieveConfig($path);

    if(empty($arr)) {
        return;
    }

    removePasswordKeys($arr);

    if(!empty($arr) && !is_array($arr)) {
        foreach (CONFIG_KEYS_TO_MASK as $skip) {
            if (strstr(strtolower($path), $skip)) {
                echo '*******';
                return;
            }
        }
    }

    echo json_encode($arr, JSON_PRETTY_PRINT);
}

// Retrieve using path. Eg: db_config.user
function retrieveConfig($path) {
    global $sugar_config;

    $paths = explode(".", $path);
    $arr = $sugar_config;
    foreach ($paths as $p) {
        if (isset($arr[$p])) {
            $arr = $arr[$p];
        } else {
            echo "Config doesn't exist: " . $path;
            return false;
        }
    }

    return $arr;
}

// Handle the request
$reqType = $_POST['type'];
if ($reqType === "searchConfig") {
    // Search for Key
    $key = $_REQUEST['key'];
    if (!empty($key)) {
        displayConfig($key);
    } else {
        echo "Search key is invalid";
    }

    return;
} else if ($reqType === "updateConfig") {

    // Update a value
    $updatePassword = $_POST['updatePassword'];
    if (!empty($updatePassword) && $updatePassword === CONFIG_MANAGER_PASSWORD) {
        $key = $_POST['updateKey'];
        $value = $_POST['updateValue'];
        if(empty($key) || empty($value)) {
            echo "Invalid Key/Value";
        } else {
            updateConfiguration($key, $value);
        }
    } else {
        echo "Password is invalid";
    }

    return;
}

function updateConfiguration($key, $value)
{
    if(!empty($key)) {
        foreach (CONFIG_KEYS_TO_DENY_UPDATE as $skip) {
            if (strstr(strtolower($key), $skip)) {
                echo 'Cannot update passwords or keys since it could cripple your system';
                return;
            }
        }
    }

    require_once 'modules/Configurator/Configurator.php';
    $configuratorObj = new Configurator();
    $configuratorObj->loadConfig();
    $config = &$configuratorObj->config;

    $paths = explode(".", $key);
    $parentArr = &$config;
    $lastKey = $key;
    $arr = &$config;
    foreach ($paths as $p) {
        if (isset($arr[$p])) {
            $parentArr = &$arr;
            $arr = &$arr[$p];
            $lastKey = $p;
        } else {
            echo "Config doesn't exist";
            return;
        }
    }

    if(is_array($arr)) {
        echo "The key provided is an array, cannot update an array field with a string!";
        return;
    }

    $parentArr[$lastKey] = $value;
    $configuratorObj->saveConfig();
    echo "Configuration Updated Successfully!";
}

// Display the template
$xtpl = new XTemplate ('custom/modules/Administration/ConfigManager.tpl');
$xtpl->assign('csrf_token', smarty_function_sugar_csrf_form_token([], $xtpl));
$xtpl->parse('main');
$xtpl->out('main');
