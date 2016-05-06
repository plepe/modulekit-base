if(typeof require !== 'undefined') {
  var assert = require('chai').assert;
  var json_readable_encode = require('../../json_readable_encode/json_readable_encode.js');
}
else {
  var assert = chai.assert;
}

describe('json_readable_encode', function() {
    it('should convert simple array', function () {
      var input = [ "a", "b", "c" ];
      var expected = '[\n    "a",\n    "b",\n    "c"\n]';
      var actual = json_readable_encode(input);

      assert.equal(expected, actual);
    });

    it('should convert object ', function () {
      var input = { "a": "a",  "b": [ 1, 2 ] };
      var expected = '{\n    "a": "a",\n    "b": [\n        1,\n        2\n    ]\n}';
      var actual = json_readable_encode(input);

      assert.equal(expected, actual);
    });
});
