<?
function pg_modules_init() {
  global $modulekit;
  $plugins_db=array();

  @$res=sql_query("select * from pg_modules");

  // if table does not exist, create
  if($res===false)
    $res=sql_query("create table pg_modules ( id text not null, updates text[], primary key(id))");

  while($elem=pg_fetch_assoc($res)) {
    $plugins_db[$elem['id']]=$elem;
  }

  foreach($modulekit['order'] as $module_id) {
    // get current list of updates
    if(!isset($plugins_db[$module_id])) {
      $plugin_updates=array();
    }
    else {
      $plugin_updates=pg_decode_array($plugins_db[$module_id]['updates']);
    }

    // build list of all updates -> array("20101010_1"=>array("sql"))
    // file_name->extensions
    $updates=array();
    $dir=modulekit_file($module_id, "update/");
    if(is_dir($dir)) {
      $d=opendir($dir);
      while($f=readdir($d)) {
	if(substr($f, 0, 1)!=".") {
	  $p=explode(".", $f);
	  $updates[$p[0]][]=$p[1];
	}
      }
      closedir($d);

    }
    ksort($updates);

    // always reload functions
    $dir=modulekit_file($module_id, "functions/");
    if(is_dir($dir)) {
      // it's a list of files: read, sort and load each one of them
      $files=array();
      $d=opendir($dir);
      while($f=readdir($d)) {
	if(preg_match("/^[^.].*\.sql/", $f))
	  $files[]=$f;
      }

      sort($files);

      foreach($files as $file) {
	debug("Module '$module_id', (re-)loading functions/$file", "pg_modules");
	sql_query(file_get_contents("$dir/$file"));
      }
    }
    elseif(file_exists(modulekit_file($module_id, "functions.sql"))) {
      // it's a single file -> load
      debug("Module '$module_id', (re-)loading functions.sql", "pg_modules");
      sql_query(file_get_contents(modulekit_file($module_id, "functions.sql")));
    }

    if((function_exists("{$module_id}_db_init"))&&
       (!isset($plugins_db[$module_id]))) {
      debug("Module '$module_id', calling db_init-function", "pg_modules");
      call_user_func("{$module_id}_db_init");
    }

    if(file_exists(modulekit_file($module_id, "db.sql"))) {
      // If plugin has never been loaded before, load db.sql
      if(!isset($plugins_db[$module_id])) {
	debug("Module '$module_id', initializing db", "pg_modules");
	sql_query(file_get_contents(modulekit_file($module_id, "db.sql")));
      }
      // load all missing updates
      else {
	$updates_done=$plugin_updates;
	foreach($updates as $update=>$files) {
	  if(!in_array($update, $updates_done)) {
	    debug("Module '$module_id', loading update $update", "pg_modules");
	    if(in_array("sql", $files))
	      sql_query(file_get_contents(modulekit_file($module_id, "update/{$update}.sql")));
	  }
	}
      }
    }

    // save update information to database
    $pg_plugin=postgre_escape($module_id);
    $pg_updates=pg_encode_array(array_keys($updates), "text");
    sql_query("delete from pg_modules where id=$pg_plugin");
    sql_query("insert into pg_modules values ($pg_plugin, $pg_updates)");
  }
}

register_hook("mcp_start", "pg_modules_init");
