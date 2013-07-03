<?
/* Additional HTML Headers */
$add_html_headers=array();

/* add_html_header() - add additional html headers to page
 * @param str string full tag(s), e.g. "<meta foo=\"bar\">"
 */
function add_html_header($str) {
  global $add_html_headers;

  $add_html_headers[]=$str;
}

/* print_add_html_headers() - print all headers, will be called from index
 * resets list of additional html headers
 */
function print_add_html_headers() {
  global $add_html_headers;

  print "<!-- add_html_headers -->\n";
  print implode("\n", $add_html_headers);
  print "\n<!-- /add_html_headers -->\n";

  $add_html_headers=null;
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
