<?php

if (!isset($actions)) {
    $actions = array();
}
array_push($actions, 'delete_all_messages');

ob_start();
require './02.php';
ob_end_clean();

if (get_username() === 'admin') {
    $html->find(':root h1')
      ->after('<p><a id="user_link">delete all messages</a></p>')
      ->find(':root a')
      ->attr('href', '03.php?action=delete_all_messages');
}

$html->writeHTML();

/*
 * FUNCTION DEFINITIONS
 */
function delete_all_messages() {
    global $db;
    $db->query('truncate table tweets');
}

//if (get_username() !== 'admin') {
//    return false;
//}
