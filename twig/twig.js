var template_cache = {};

function twig_render_into_final(dom_node, template_id, data, result) {
  if(!(template_id in template_cache))
    template_cache[template_id] = twig({ data: result });

  dom_node.innerHTML = template_cache[template_id].render(data);
}

function twig_render_into(dom_node, template_id, data) {
  if(template_id in template_cache) {
    twig_render_into_final(dom_node, template_id, data);
  }
  else {
    ajax('templates/' + template_id, null, twig_render_into_final.bind(this, dom_node, template_id, data));
  }
}

function twig_render_custom(template, data) {
  var t = twig({ data: template });
  return t.render(data);
}

register_hook("init", function() {
  call_hooks("twig_init");
});
