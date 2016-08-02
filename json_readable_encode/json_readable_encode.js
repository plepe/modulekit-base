(function() {
  function json_readable_encode(data) {
    return JSON.stringify(data, null, '    ');
  }

  if(typeof register_hook !== 'undefined') {
    register_hook("twig_init", function() {
      Twig.extendFilter('json_readable_encode', function(data) {
        return json_readable_encode(data);
      });
    });
  }

  if(typeof exports !== 'undefined') {
    if(typeof module !== 'undefined' && module.exports) {
      exports = module.exports = json_readable_encode;
    }
    exports.json_readable_encode = json_readable_encode;
  }
  else {
    this.json_readable_encode = json_readable_encode;
  }

}).call(this);
