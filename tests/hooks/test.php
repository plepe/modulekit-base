<?php
include "hooks/hooks.php";

class hooks_test extends PHPUnit_Framework_TestCase {
  public function testRegisterHook_CallHook() {
    register_hook('foo1', function($foo) {
      $this->assertEquals($foo, 'AAA');
    });

    $value = 'AAA';
    call_hooks('foo1', $value);
  }

  public function testReturnValues() {
    register_hook('foo2', function() {
      return 'foo';
    });
    register_hook('foo2', function() {
      return 'bar';
    });

    $expected = array('foo', 'bar');
    $actual = call_hooks('foo2');

    $this->assertEquals($expected, $actual);

  }
}
