function messages_expand() {
  if(this.className == "messages_expandable")
    this.className = "messages_expanded";
  else
    this.className = "messages_expandable";
}

register_hook("init", function() {
  var obs = document.getElementsByTagName("div");
  for(i=0; i<obs.length; i++) {
    ob = obs.item(i);
    if(ob.className == "messages_expandable")
      ob.onclick=messages_expand.bind(ob);
  }
});
