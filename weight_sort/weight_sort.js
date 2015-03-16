// weight_sort(arr)
// Parameters:
// arr ... an array of form [ [ weight, var], ... ]
//         [ [ -3, A ], [ -1, B ], [ 5, C ], [ -1, D ] ]
//         
// Returns:
// An array sorted by the weight of the source, e.g.
//         [ A, B, D, C ]
//
// Notes:
// Entries in the source array with the same weight are returned in the
// same order
function weight_sort(arr) {
  function numerical_cmp(a, b) {
    return a-b;
  }

  var ret1={};

  // first put all elements into an assoc. array
  for(var i=0; i<arr.length; i++) {
    var cur=arr[i];
    var wgt=cur[0];
    if(!wgt)
      wgt=0;

    if(!ret1[wgt])
      ret1[wgt]=[];

    ret1[wgt].push(cur[1]);
  }

  // get the keys, convert to value, order them
  var keys1=keys(ret1);
  keys1.sort(numerical_cmp);
  var ret2=[];

  // iterate through array and compile final return value
  for(var i=0; i<keys1.length; i++) {
    for(var j=0; j<ret1[keys1[i]].length; j++) {
      ret2.push(ret1[keys1[i]][j]);
    }
  }

  return ret2;
}
