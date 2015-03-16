// weight_sort(arr)
// Parameters:
// arr ... an array of form [ [ weight, var], ... ]
//         [ [ -3, A ], [ -1, B ], [ 5, C ], [ -1, D ] ]
//         OR
//         an array of form [ { 'weight': value, other key/values } ]
//         [ { 'weight': -3, k: A ], { 'weight': -1, v: B }, [ 5, C ] ]
//
//  as the last item shows, you can even mix the forms
//
// Returns:
// if the first form is used, only the 'var' will be returned; with the
// second form the elements are untouched, only their position changed.
//
// Notes:
// Entries in the source array with the same weight are returned in the
// same order
// * weight might be a function closure
function weight_sort(arr) {
  function numerical_cmp(a, b) {
    return a-b;
  }

  var ret1={};

  // first put all elements into an assoc. array
  for(var i=0; i<arr.length; i++) {
    var cur=arr[i];
    var wgt;
    var data;

    if(cur.length) {
      wgt = cur[0];
      data = cur[1];
    }
    else {
      wgt = cur.weight;
      data = cur;
    }

    if(typeof wgt == "function")
      wgt = wgt();

    if(!wgt)
      wgt=0;

    if(!ret1[wgt])
      ret1[wgt]=[];

    ret1[wgt].push(data);
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
