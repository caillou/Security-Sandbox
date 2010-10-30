<?php
ob_start();
require './03.php';
ob_end_clean();

if (is_logged_in()) {
  
  $html->find(':root h1')
    ->after('<p><a id="user_link">edit user</a></p>')
    ->find(':root a')
    ->attr('href', '/pages/user.php?username=' . get_username());

}
$html->writeHTML();