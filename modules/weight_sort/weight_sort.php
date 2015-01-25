<?php
// weight_sort(arr)
// Parameters:
// arr ... an array of elements
//           an element may be: array( weight, var )
//           or array('weight'=>weight, ...)
//
// e.g.:
//       array( 'g'=>array( -3, A ), array( -1, B ), array( 'weight'=>5, 'foo'=>'bar' ), 'f'=>array( -1, D ) )
//
// Returns:
// An array sorted by the weight of the source, e.g.
//         array( 'g'=>A, B, 'f'=>D, array('weight'=>5, 'foo'=>'bar') )
// if the first form is used, only the 'var' will be returned; with the
// second form the elements are untouched, only their position changed.
//
// Notes:
// Entries in the source array with the same weight are returned in the
// same order
function weight_sort($arr) {
  $ret1=array();

  if(!$arr)
    return array();

  // first put all elements into an assoc. array
  foreach($arr as $k=>$cur) {
    if((sizeof($cur)==2)&&array_key_exists(0, $cur)&&array_key_exists(1, $cur)) {
      $wgt=$cur[0];
      $ret1[$wgt][$k]=$cur[1];
    }
    else {
      $wgt=(isset($cur['weight'])?$cur['weight']:0);
      $ret1[$wgt][$k]=$cur;
    }
  }

  // get the keys, convert to value, order them
  ksort($ret1);
  $ret2=array();

  // iterate through array and compile final return value
  foreach($ret1 as $cur) {
    foreach($cur as $j=>$d) {
      $ret2[$j]=$cur[$j];
    }
  }

  return $ret2;
}


