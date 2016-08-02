Functions
=========
csrf_get_token()
----------------
Returns the current csrf token.

csrf_show_token()
-----------------
Returns a HTML formatted input with the name 'csrf_token' and the token.

csrf_verify_token()
-------------------
Return true if the csrf token is correct, otherwise throw an exception.

csrf_check_token($msg=false)
------------------
Return true if the csrf token is correct, otherwise return false.

If parameter $msg is true, it will post an error message (if the csrf token is wrong; if it is not set at all it will return false without error message) via the messages module. If $msg is a string, it will use the string instead.

Translated Strings
==================
'csrf:error': Error message which can be used to indicate failure.

