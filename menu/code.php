<?php
class Menu {
  function __construct($id, $entries=array(), $options=array()) {
    $this->id = $id;
    $this->entries = $entries;
    $this->options = $options;

    call_hooks('menu_entries', $this);
  }

  function add_entry($entry) {
    $this->entries[] = $entry;
  }

  function show() {
    $ret = "";

    if(sizeof($this->entries)) {
      $ret .= "<div class='menu' id='{$this->id}'>\n";
      $this->entries = weight_sort($this->entries);
      foreach($menu_entries as $entry) {
	$ret .= "<a href='{$entry['url']}'>{$entry['text']}</a>\n";
      }
      $ret .= "</div>\n";
    }

    return $ret;
  }
}
