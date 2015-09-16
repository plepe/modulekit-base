<?php
function str_to_id($str) {
  $str = strtolower($str);

  $str = strtr($str, array(
    ' ' => '_',
    '-' => '_',
    '(' => '_',
    ')' => '_',
    '"' => '_',
    "'" => '_',
    '`' => '_',
    '[' => '_',
    ']' => '_',
    '\n' => '_',
    '\t' => '_',
    '!' => '_',
    '$' => '_',
    '%' => '_',
    '&' => '_',
    '+' => '_',
    '*' => '_',
    ',' => '_',
    '.' => '_',
    '/' => '_',
    ':' => '_',
    ';' => '_',
    '=' => '_',
    '<' => '_',
    '>' => '_',
    '?' => '_',
    '\\' => '_',
    '{' => '_',
    '}' => '_',
    '^' => '_',
    '|' => '_',
    '~' => '_',
  ));

  do {
    $length = strlen($str);
    $str = strtr($str, array('__' => '_'));
  } while(strlen($str) < $length);

  $str = substr($str, 0, 32);

  return $str;
}
