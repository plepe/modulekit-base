<?php
if(include "{$modulekit['root_path']}/lib/Twig/lib/Twig/Autoloader.php") {
Twig_Autoloader::register();

class CustomTwigTemplates implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{
    public function getSource($name)
    {
	if(substr($name, 0, 7) == "custom:")
	  return substr($name, 7);

	throw new Twig_Error_Loader(sprintf('Temporary template does not exist.'));
    }

    // Twig_ExistsLoaderInterface as of Twig 1.11
    public function exists($name)
    {
	if(substr($name, 0, 7) == "custom:")
	  return true;
    }

    public function getCacheKey($name)
    {
	return $name;
    }

    public function isFresh($name, $time)
    {
	return true;
    }
}

register_hook("init", function() {
  global $modulekit;
  global $twig;

  $loaders = call_hooks("twig_loaders");
  $loaders[] = new Twig_Loader_Filesystem("{$modulekit['root_path']}/templates");
  $loaders[] = new CustomTwigTemplates();

  $loader = new Twig_Loader_Chain($loaders);
  $twig = new Twig_Environment($loader);

  call_hooks("twig_init");
});
}

function twig_render($template_id, $data) {
  global $twig;

  if(!$twig) {
    trigger_error("Twig library could not be loaded!");
  }

  return $twig->render($template_id, $data);
}

function twig_render_custom($template, $data) {
  global $twig;

  if(!$twig) {
    trigger_error("Twig library could not be loaded!");
  }

  return $twig->render("custom:" . $template, $data);
}
