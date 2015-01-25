<?php
$mysql_default=null;

function sql($query, $mysql_data=null) {
  global $mysql_default;
  
  if(!$mysql_data)
    $mysql_data=$mysql_default;

  if(!mysql_select_db($mysql_data[db], $mysql_data[linkid])) {
    echo "Can't select database!<br>";
    exit;
  }

  if($mysql_data['debug']&1)
    print "<!-- SQL-Query: $query -->\n";
  if($mysql_data['debug']&2) {
    global $path_config;
    global $current_user;

    file_put_contents("$path_config/.debug.log",
      timestamp()."\t".
      $current_user->id.":\n".
      $query."\n",
      FILE_APPEND|LOCK_EX);
  }

  if(!$res=mysql_query($query, $mysql_data[linkid])) {
    echo mysql_error();
    exit;
  }
  return $res;
}

function sql_connect(&$mysql_data=null) {
  global $mysql_default;
  global $design_hidden;

  if(!$mysql_data) {
    $mysql_data=$mysql_default;
    $mysql_default=0;
  }

  if($design_hidden)
    $mysql_data[debug]=0;

  if(!$mysql_data[linkid]=mysql_connect($mysql_data[host], $mysql_data[user], $mysql_data[passwd])) {
    echo "Fehler beim Verbindungsaufbau!<br>";
    exit;
  }

  if(!mysql_select_db($mysql_data[db], $mysql_data[linkid])) {
    echo "Can't select database!<br>";
    exit;
  }

  if(!$mysql_default)
    $mysql_default=$mysql_data;

  mysql_query("set names 'utf8'", $mysql_data['linkid']);

  return $mysql_data;
}

function sql_close($mysql_data=null) {
  global $mysql_default;

  if(!$mysql_data)
    $mysql_data=$mysql_default;

  mysql_close($mysql_data[linkid]);
  unset($mysql_data[linkid]);
}

function sql_fetch_assoc($res) {
  return mysql_fetch_assoc($res);
}

function sql_fetch($res) {
  return mysql_fetch_assoc($res);
}

function sql_num_rows($res) {
  return mysql_num_rows($res);
}

function sql_insert_id() {
  return mysql_insert_id();
}

function sql_build_set($data, $exclude=array()) {
  $str=array();
  foreach($data as $k=>$v) {
    if(!in_array($k, $exclude)) {
      if($v)
        $str[]="$k=\"$v\"";
      else
        $str[]="$k=null";
    }
  }

  return $str;
}

$mysql=sql_connect($mysql);
