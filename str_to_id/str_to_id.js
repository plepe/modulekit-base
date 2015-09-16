function str_to_id(str) {
  str = str.toLowerCase();
  str = str.replace(/[ -\(\)\[\]"'`\/\n\t!\$%&\+\*,\.:;=<>\?\\\{\}^\|~]/g, '_');

  var length ;
  do {
    length = str.length;
    str = str.replace(/__/g, '_');
  } while(str.length < length);

  str = str.substr(0, 32);

  return str;
}
