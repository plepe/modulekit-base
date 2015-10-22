<?php
/* Additional HTML Headers */
$add_html_headers=array();

/* add_html_header() - add additional html headers to page
 * @param str string full tag(s), e.g. "<meta foo=\"bar\">"
 */
function add_html_header($str, $weight=0) {
  global $add_html_headers;

  $add_html_headers[]=array($weight, $str);
}

/* get_add_html_headers() - returns all headers, will be called from index
 * resets list of additional html headers
 */
function get_add_html_headers() {
  global $add_html_headers;

  if(!$add_html_headers)
    return;

  $add_html_headers=weight_sort($add_html_headers);

  $ret  = "<!-- add_html_headers -->\n";
  $ret .= implode("\n", $add_html_headers);
  $ret .= "\n<!-- /add_html_headers -->\n";

  $add_html_headers=null;

  return $ret;
}

/* print_add_html_headers() - directly print headers to stdout
 * legacy function - use get_add_html_headers() instead.
 */
function print_add_html_headers() {
  print get_add_html_headers();
}

/* html_export_var() - exports variables to JavaScript
 * e.g.
 * html_export_var(array("foo"=>"bar", "test"=>array(1, 2)));
 * ->
 *   var foo="bar";
 *   var test=[1,2];
 */
function html_export_var($data) {
  global $add_html_headers;

  $ret ="<script type='text/javascript'>\n";
  foreach($data as $k=>$v) {
    $ret.="var $k=".json_encode($v).";\n";
  }
  $ret.="</script>\n";

  if(is_array($add_html_headers))
    $add_html_headers[]=$ret;
  else
    print $ret;
}

function html_export_to_input($var_name, $value) {
  if(is_array($value)) {
    $ret = "";
    foreach($value as $k=>$v) {
      $ret .= html_export_to_input("{$var_name}[" . htmlspecialchars($k) . "]", $v);
    }

    return $ret;
  }
  else {
    return "<input type='hidden' name='{$var_name}' value=\"" . htmlspecialchars($value) . "\"/>\n";
  }
}
