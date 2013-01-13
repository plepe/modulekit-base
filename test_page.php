<?php include "conf.php"; /* load a local configuration */ ?>
<? $modulekit_load=array("page"); ?>
<?php include "modulekit/loader.php"; /* loads all php-includes */ ?>
<?
class Page_default extends Page {
  function content() {
    $other_page=get_page("other");

    return "default page. <a href='{$other_page->url()}'>other page</a>.";
  }
}

class Page_other extends Page {
  function content() {
    $default_page=get_page();

    return "other page. <a href='{$default_page->url()}'>default page</a>.";
  }
}

$page=get_page($_REQUEST);
if(!$page) {
  $content="Invalid Page!";
}
else {
  $content=$page->content();
}

?>
<html>
  <head>
    <title>Framework Example</title>
    <?php print modulekit_to_javascript(); /* pass modulekit configuration to JavaScript */ ?>
    <?php print modulekit_include_js(); /* prints all js-includes */ ?>
    <?php print modulekit_include_css(); /* prints all css-includes */ ?>
  </head>
  <body>
<?
print $content;
?>
  </body>
</html>
