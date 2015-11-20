function json_readable_encode(data) {
  return JSON.stringify(data, null, '    ');
}

register_hook("twig_init", function() {
  Twig.extendFilter('json_readable_encode', function(data) {
    return json_readable_encode(data);
  });
});
