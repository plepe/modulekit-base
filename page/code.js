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

function _page_res_insert(ret, key, value) {
  if(var m =key.match(
  ret[key] = value;
}

function page_resolve_url_params(url) {
  var m;
  if(!url) {
    url = document.location.search.substr(1);
  }
  else if(m = url.match(/^[^\?]*\?(.*)/)) {
    url = m[1];
  }

  var ret = {};
  var ar = url.split(/&/);

  for(var i = 0; i < ar.length; i++) {
    var x = ar[i].split(/=/);
    var key = decodeURIComponent(x[0]);
    x.shift();
    var value = decodeURIComponent(x.join(/=/));
    _page_res_insert(ret, key, value);
  }

  return ret;
}

register_hook("twig_init", function() {
  Twig.extendFunction("page_url", function(param) {
    return page_url(param);
  });
});
