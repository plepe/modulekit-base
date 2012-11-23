<?
function register_pg_schema($schema_id) {
  global $pg_schemas;
  global $pg_schemas_tr;

  if(!isset($pg_schemas[$schema_id]))
    $pg_schemas[$schema_id]=$schema_id;

  foreach($pg_schemas as $id=>$data) {
    $pg_schemas_tr["@{$id}@"]=$data;
  }
}

function pg_schema_expand_schemas($qry, $conn) {
  global $pg_schemas_tr;

  $qry=strtr($qry, $pg_schemas_tr);
}

if(!isset($pg_schemas))
  $pg_schemas=array();
if(!isset($pg_schemas['user']))
  register_pg_schema("user", $db['user']); // default user schema

register_hook("pg_sql_query", "pg_schema_expand_schemas");
