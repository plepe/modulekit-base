/**
 * Hooks - Functions can register to hooks and will be called on certain 
 * events in the system.
 *
 * <code>
 * function example(p) {
 *   alert("example "+p);
 * }
 * register_hook("test_hook", example);
 * </code>

 */

/**
 * Holds a list of all functions which registered a hook
 * @var array array('hook'=>array(fun, fun, fun))
 */
var hooks_intern=new Array();

/**
 * Holds a list of all hooks of an object, to savely remove all hooks of an object
 */
var hooks_object_objects=[];
var hooks_object_hooks=[];

function hooks_array_search(el, arr) {
  for(var i=0; i<arr.length; i++) {
    if(arr[i]===el)
      return i;
  }

  return false;
}

/**
 * Call hooks - All registered functions will be called
 * @param text hook The hooks to be called
 * @param any vars A variable which will be passed by reference and can therefore by modified
 * @param any params Additional vars
 */
function call_hooks(hook, vars, param1, param2, param3, param4) {
  var ret=[];

  if(hooks_intern[hook])
    for(var i=0; i<hooks_intern[hook].length; i++) {
      var r=hooks_intern[hook][i](vars, param1, param2, param3, param4);

      if(r!=null)
	ret.push(r);
    }

  return ret;
}

/**
 * Call hooks with callback - All registered functions will be called. As last
 * parameter a callback function will be accepted which will be called, when
 * all called hooks answered by calling an intermediate callback function.
 * The callback will be passed an array which consists of all (first) values
 * which the hooks passed to their callbacks (without null values).
 *
 * @param text hook The hooks to be called
 * @param any vars A variable which will be passed by reference and can therefore by modified
 * @param any params Additional vars
 */
function call_hooks_callback(hook) {
  var callback=arguments[arguments.length-1];

  // no hooks defined? call callback directly
  if((!hooks_intern[hook])||(hooks_intern[hook].length==0)) {
    callback([]);
    return;
  }

  var count=hooks_intern[hook].length;
  var ret=[];

  // pass all arguments save the first
  var args=Array.prototype.slice.call(arguments);
  args=args.slice(1);

  // replace callback by own callback
  args[args.length-1]=function(v) {
    // add value to return values
    if(v)
      ret.push(v);

    // if this was the last hook to answer, call final callback function
    if(--count==0)
      callback(ret);
  };


  // call all hooks
  for(var i=0; i<hooks_intern[hook].length; i++) {
    hooks_intern[hook][i].apply(this, args);
  }
}

/**
 * Register a function to a hook
 * @param text hook The hook the function to register to
 * @param text fun The reference to the function
 * @param object saves this hook to be part of object ob, therefore hook can be saveely removed, when object is being discarded
 */
function register_hook(hook, fun, ob) {
  if(!hooks_intern[hook])
    hooks_intern[hook]=new Array();

  hooks_intern[hook].push(fun);

  if(ob) {
    var p=hooks_array_search(ob, hooks_object_objects);
    if(p===false) {
      p=hooks_object_objects.length;
      hooks_object_objects.push(ob);
      hooks_object_hooks.push([]);
    }
    
    hooks_object_hooks[p].push([ hook, fun ]);
  }
}

/**
 * Unregisters all hooks of an object
 * @param object The object
 */
function unregister_hooks_object(ob) {
  var p=hooks_array_search(ob, hooks_object_objects);
  if(p===false)
    return;

  for(var i=0; i<hooks_object_hooks[p].length; i++) {
    var hook=hooks_object_hooks[p][i][0];
    var fun1=hooks_object_hooks[p][i][1];

    for(var j=0; j<hooks_intern[hook].length; j++) {
      var fun2=hooks_intern[hook][j];
      if(fun1==fun2) {
	hooks_intern[hook].splice(j, 1);
	j--;
      }
    }
  }

  delete(hooks_object_objects[p]);
  delete(hooks_object_hooks[p]);
}

// nodejs compatibility
if((typeof(module)!="undefined")&&module.exports) {
  module.exports.call=call_hooks;
  module.exports.call_callback=call_hooks_callback;
  module.exports.register=register_hook;
}
else {
  window.hooks={
    call: call_hooks,
    call_callback: call_hooks_callback,
    register: register_hook
  };
}
