function opt_sort(data, sorts) {
  data = data.slice();

  data.sort(function(sorts, a, b) {
    for(var si in sorts) {
      var s = sorts[si];
      var dir = 1;
      if(s.dir)
        dir = (s.dir == 'desc' ? -1 : 1);

      if(s.null && ((a[s.key] === null) || (b[s.key] === null))) {
	if((a[s.key] === null) && (b[s.key] === null))
	  continue;

	switch(s.null) {
	  case 'first':
	    return a[s.key] !== null;
	  case 'last':
	    return a[s.key] === null;
	  case 'higher':
	    if (a[s.key] === null)
	      return s.dir === 'asc';
	    if (b[s.key] === null)
	      return s.dir === 'desc';
	  case 'lower':
	  default:
        }
      }

      switch(s.type) {
        case 'num':
        case 'numeric':
          var av = parseFloat(a[s.key]);
          var bv = parseFloat(b[s.key]);

          if(av == bv)
            continue;

          if(isNaN(av))
            return -1;
          if(isNaN(bv))
            return 1;

          var c = (av > bv) ? 1 : -1;
          return c * dir;

        case 'nat':
          // TODO!
          break;

        case 'case':
          var av = (a[s.key] + '').toLowerCase();
          var bv = (b[s.key] + '').toLowerCase();

          if(av == bv)
            continue;

          c = (av > bv) ? 1 : -1;
          return c * dir;

        case 'alpha':
        default:
          var av = (a[s.key] + '');
          var bv = (b[s.key] + '');

          if(av == bv)
            continue;

          c = (av > bv) ? 1 : -1;
          return c * dir;
      }
    }

    return 0;
  }.bind(this, sorts));

  return data;
}
