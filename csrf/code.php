<?php
function csrf_get_token() {
  if(empty($_SESSION['csrf_token']))
    $_SESSION['csrf_token'] = base64_encode( openssl_random_pseudo_bytes(33));

  return $_SESSION['csrf_token'];
}

function csrf_show_token() {
  return "<input type='hidden' name='csrf_token' value='" . csrf_get_token() . "' />\n";
}

function csrf_verify_token() {
  if($_SESSION['csrf_token'] === $_REQUEST['csrf_token'])
    return true;

  throw new Exception("Possible cross-site-request-forgery (CSRF) detected!");
}
