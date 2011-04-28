<?php

//ini_set('session.cookie_httponly', true);

if (!isset($actions)) {
    $actions = array();
}
array_push($actions, 'update_message');

ob_start();
require './01.php';
ob_end_clean();



if (is_logged_in()) {
  $html->find(':root body')
    ->append('<form/>')
    ->find('form:last-of-type')
    ->append('<input type="hidden" name="action" value="update_message"/>')
    ->append('<textarea name="message"></textarea>')
    ->append('<input type="submit" value="update"/>');
}

$html->find(':root body')
  ->append(get_latest_messages());

$html->writeHTML();

/*
 * FUNCTION DEFINITIONS
 */
function is_logged_in() {
  return isset($_SESSION['user']) && $_SESSION['user'];
}
function get_username() {
  if (!is_logged_in()) {
    return 'anonymous';
  }
  return $_SESSION['user']->username;
}

function update_message() {
  global $db;
  
  $u = get_username();
  $m = $_REQUEST['message'];
  
  $sql = "insert into tweets (username, message) values ('$u', '$m');";
  $db->query($sql);
}

function get_latest_messages() {
  global $db;
  global $html;
  
  $html->find(':root body');
  $html->append('<h2>Recent Tweets</h2><dl/>');
  
  
  $tweets = $db->query('select * from tweets order by creation_time desc limit 0,4');
  $tweets->setFetchMode(PDO::FETCH_OBJ);
  
  foreach ($tweets as $tweet) {
    $html->find(':root dl')
      ->append('<dt/>')
      ->find('dt:last-of-type')
      ->html($tweet->username)
      ->parent()
      ->append('<dd/>')
      ->find('dd:last-of-type')
      ->html($tweet->message);
  }
  
  return '';
}

//<script>document.write(document.cookie);</script>
// evil.lo