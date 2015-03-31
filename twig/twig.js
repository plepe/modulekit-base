function twig_render_custom(template, data) {
  var t = twig({ data: template });
  return t.render(data);
}
