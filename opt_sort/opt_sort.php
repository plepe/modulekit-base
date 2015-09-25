<?php
function opt_sort($data, $sorts) {
  // add __index value, to maintain value order on equal entries
  $i = 0;
  foreach($data as $k=>$d) {
    if(is_object($data[$k]))
      $data[$k]->__index = $i++;
    else
      $data[$k]['__index'] = $i++;
  }

  usort($data, function($a, $b) use ($sorts) {
    foreach($sorts as $s) {
      $dir = 1;
      if(array_key_exists('dir', $s))
        $dir = $s['dir'] == 'desc' ? -1 : 1;

      if(array_key_exists('null', $s) &&
	(($a[$s['key']] === null) || ($b[$s['key']] === null))) {

	if((($a[$s['key']] === null) && ($b[$s['key']] === null)))
	  continue;

	switch($s['null']) {
	  case 'first':
	    return $a[$s['key']] !== null;
	  case 'last':
	    return $a[$s['key']] === null;
	  case 'higher':
	    if($a[$s['key']] === null)
	      return $s['dir'] === 'asc';
	    if($b[$s['key']] === null)
	      return $s['dir'] === 'desc';
	  case 'lower':
	  default:
	    break;
	}
      }

      switch(!array_key_exists('type', $s) ? null : $s['type']) {
        case 'num':
        case 'numeric':
          if((float)$a[$s['key']] == (float)$b[$s['key']])
            continue;

          $c = (float)$a[$s['key']] > (float)$b[$s['key']] ? 1 : -1;
          return $c * $dir;

        case 'nat':
          $c = strnatcmp($a[$s['key']], $b[$s['key']]);

          if($c === 0)
            continue;

          return $c * $dir;

        case 'case':
          $c = strcasecmp($a[$s['key']], $b[$s['key']]);

          if($c === 0)
            continue;

          return $c * $dir;

        case 'alpha':
        default:
          $c = strcmp($a[$s['key']], $b[$s['key']]);

          if($c === 0)
            continue;

          return $c * $dir;
      }
    }

    // equal entries for sorting -> maintain value order
    return (is_object($a) ? $a->__index : $a['__index'])
           >
           (is_object($b) ? $b->__index : $b['__index']);
  });

  return $data;
}
