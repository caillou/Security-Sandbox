<?php
require '../lib/QueryPath/QueryPath.php';
require '../conf/config.php';

header("Content-Type: text/plain");

// get the user info
var_dump($db->query('select * from user where username = ' . $db->quote($_REQUEST['username']))->fetchObject());