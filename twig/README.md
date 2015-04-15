twig.php
========
Clone git://github.com/twigphp/Twig.git into lib/Twig

twig.js
=======
Clone https://github.com/justjohn/twig.js into lib/twig.js/

Functions
=========
twig_render(template_id, data)
------------------------------
Loads the file (e.g. 'footer.html') from `templates/`-directory and renders with the given data. Returnes rendered output.

Scope: available only in PHP

twig_render_custom(template, data)
-------------------------------------
Pass the source of a template as first parameter, render with given data. Returns rendered output.

Scope: PHP and JS
