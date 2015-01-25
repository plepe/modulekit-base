<?php
define(MSG_ERROR, "error");
define(MSG_NOTICE, "notice");
define(MSG_DEBUG, "debug");
global $messages_keep;
$messages_keep=false;

function messages_add($text, $level=MSG_NOTICE) {
  if(!isset($_SESSION['messages']))
    $_SESSION['messages']=array();
  if(!isset($_SESSION['messages'][$level]))
    $_SESSION['messages'][$level]=array();

  $_SESSION['messages'][$level][]=$text;
}

function messages_debug() {
  $text = array();

  foreach(func_get_args() as $var) {
    if(in_array(gettype($var), array("array", "object")))
      $text[] = "<pre>" . print_r($var, 1) . "</pre>";
    elseif($var === null)
      $text[] = "(null)";
    elseif(gettype($var) == "string")
      $text[] = "(string): \"{$var}\"";
    else
      $text[] = "(".gettype($var)."): {$var}";
  }

  $text = implode("<br>\n", $text);

  $text = "<div class='messages_expandable'>{$text}</div>";
  messages_add($text, MSG_DEBUG);
}

function messages_print() {
  if(!isset($_SESSION['messages']))
    return "";

  $ret ="<div class='messages'>\n";
  foreach($_SESSION['messages'] as $level=>$msgs) {
    $ret.="  <ul class='$level'>\n";
    foreach($msgs as $msg) {
      $ret.="  <li>$msg</li>\n";
    }
    $ret.="  </ul>\n";
  }
  $ret.="</div>\n";

  global $messages_keep;
  if(!$messages_keep)
    unset($_SESSION['messages']);

  return $ret;
}

function messages_keep() {
  global $messages_keep;
  $messages_keep=true;
}

if(function_exists("register_hook")) {
  register_hook("page_reload", function() {
    messages_keep();
  });
}
