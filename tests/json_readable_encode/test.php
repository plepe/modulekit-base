<?php
include "hooks/hooks.php";
include "json_readable_encode/json_readable_encode.php";

class form_element_checkbox_test extends PHPUnit_Framework_TestCase {
  public function testSimpleArray() {
    $input = array( "a", "b", "c");
    $expected = "[\n    \"a\",\n    \"b\",\n    \"c\"\n]";
    $actual = json_readable_encode($input);

    $this->assertEquals($expected, $actual);
  }
}
