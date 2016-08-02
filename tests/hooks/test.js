if(typeof require !== 'undefined') {
  var assert = require('chai').assert;
  var hooks = require('../../hooks/hooks.js');
}
else {
  var assert = chai.assert;
}

describe('hooks', function() {
    it('register to a hook and call the supplied function', function (done) {
      hooks.register('foo1', function() {
        done();
      });
      hooks.call('foo1');
    });

    it('collect return values in an array', function () {
      hooks.register('foo2', function() {
        return 'foo';
      });
      hooks.register('foo2', function() {
        return 'bar';
      });

      var expected = ['foo', 'bar'];
      var actual = hooks.call('foo2');

      assert.sameMembers(expected, actual);
    });
});
