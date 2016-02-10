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

csrf_check_token()
------------------
Return true if the csrf token is correct, otherwise return false.
