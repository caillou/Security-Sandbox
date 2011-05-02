<?php
# 1. Injection
# ++++++++++++
#
# Injection flaws, such as SQL, OS, and LDAP injection, occur when untrusted data is sent
# to an interpreter as part of a command or query. The attacker’s hostile data can trick 
# the interpreter into executing unintended commands or accessing unauthorized data.

session_start();
require './lib/vendor/querypath/src/QueryPath/QueryPath.php';

// get the $db
require './conf/config.php';

$html = qp(QueryPath::HTML_STUB)
  ->find('title')
  ->text('Security: Injections')
  ->find(':root body')
  ->append('<h1/><form/>');

if (isset($_REQUEST['action'])) {
  $function = $_REQUEST['action'];
  eval($function . '();');
}


if (isset($_SESSION['user'])) {
  $html->find(':root h1')
    ->text('Hi ' . $_SESSION['user']->username)
    ->parent()->find('form')
    ->append('<input type="hidden" name="action" value="logout"/>')
    ->append('<input type="submit" value="logout"/>');
} else {
  $html->find(':root h1')
    ->text('Please Login')
    ->parent()->find('form')
    ->append('<input type="hidden" name="action" value="login"/>')
    ->append('<label for="username">User:</label>')
    ->append('<input type="text" name="username"/>')
    ->append('<label for="pass">Pass:</label>')
    ->append('<input type="password" name="pass"/>')
    ->append('<input type="submit" value="login"/>');
}

$html->writeHTML();

function login() {
  global $db;
  $user = $_REQUEST['username'];
  $pass = md5($_REQUEST['pass']);
  $sql = "select * from user where username = '$user' and pass = '$pass'";

  $user = $db->query($sql)->fetchObject();
  
  if ($user) {
    $_SESSION['user'] = $user;
  } else {
    global $html;
    $html->find(':root h1')
      ->after('<div style="color:red;">login failed</div>');
  }
}

function logout() {
  session_unset();
  session_destroy();
}


# ' or '1' = '2

# $stmt = $db->prepare("select * from user where username = ? and pass = ?");
# $stmt->execute(array($user, $pass));
# $user = $stmt->fetchObject();

#if (!isset($actions)) {
#    $actions = array();
#}
#array_push($actions, 'login', 'logout');
#
#if (in_array($function, $actions)) {
#   call_user_func($function);
#}