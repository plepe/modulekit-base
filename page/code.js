function page_url_helper(param, prefix) {
  if(!prefix)
    prefix = "";

  var ret = [];
  var c = 0;

  for(var k in param) {
    var v = param[k];
    var cur_prefix;

    // twig.js adds _keys as property
    if(k == '_keys')
      continue;

    if(prefix == "") {
      if(typeof(v) == "object") {
	cur_prefix = encodeURIComponent(k);
	ret = ret.concat(page_url_helper(v, cur_prefix));
      }
      else
	ret.push(k + "=" + encodeURIComponent(v));
    }
    else {
      if((typeof(k) == "number") && (c == k)) {
	cur_prefix = prefix + "[]";
	c++;
      }
      else {
	cur_prefix = prefix + "[" + encodeURIComponent(k) + "]";
      }

      if(typeof(v) == "object")
	ret = ret.concat(page_url_helper(v, cur_prefix));
      else
	ret.push(cur_prefix + "=" + encodeURIComponent(v));
    }
  }

  return ret;
}

function page_url(param, options) {
  if(typeof(param) == 'string')
    return param;

  str = page_url_helper(param);

  return "?" + str.join("&amp;");
}
