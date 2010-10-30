<?php
ob_start();
require './02.php';
ob_end_clean();


$html->writeHTML();

/*
 * FUNCTION DEFINITIONS
 */
function delete_all_messages() {
  global $db;
  $db->query('truncate table tweets');
}