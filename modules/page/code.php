<?
function get_page($param=array(), $options=array()) {
  if(is_string($param))
    $param=array("page"=>$param);
  if(!isset($param['page']))
    $param['page']="default";

  $class="Page_{$param['page']}";

  if(!class_exists($class))
    return false;

  return new $class($param, $options);
}

function page_url_helper($param, $prefix="") {
  $ret=array();
  $c=0;

  foreach($param as $k=>$v) {
    if($prefix=="") {
      if(is_array($v)) {
        $cur_prefix=urlencode($k);
        $ret=array_merge($ret, page_url_helper($v, $cur_prefix));
      }
      else
        $ret[]=urlencode($k)."=".urlencode($v);
    }
    else {
      $cur_prefix=null;

      if(is_numeric($k)&&($c==$k)) {
        $cur_prefix="{$prefix}[]";
        $c++;
      }
      else
        $cur_prefix="{$prefix}[".urlencode($k)."]";

      if(is_array($v))
        $ret=array_merge($ret, page_url_helper($v, $cur_prefix));
      else
        $ret[]=$cur_prefix."=".urlencode($v);
    }
  }

  return $ret;
}

function page_url($param, $options=array()) {
  $str=page_url_helper($param);

  return "?".implode("&amp;", $str);
}

class Page {
  function __construct($param, $options) {
    $this->param=$param;
    $this->options=$options;
  }

  function content() {
  }

  function url() {
    return page_url($this->param, $this->options);
  }
}
