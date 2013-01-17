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
