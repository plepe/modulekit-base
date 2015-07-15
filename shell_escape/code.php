<?php
function shell_escape($str) {
  return '"' . strtr($str, array('"' => '\\"')) . '"';
}
