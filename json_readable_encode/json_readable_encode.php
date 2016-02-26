<?php

/*
    json readable encode
    basically, encode an array (or object) as a json string, but with indentation
    so that i can be easily edited and read by a human

    THIS REQUIRES PHP 5.3+

    Copyleft (C) 2008-2011 BohwaZ <http://bohwaz.net/>

    Licensed under the GNU AGPLv3

    This software is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This software is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this software. If not, see <http://www.gnu.org/licenses/>.
*/

function json_readable_encode($in, $indent_string = "    ", $indent = 0, Closure $_escape = null)
{
    if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
      $ret = json_encode($in, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
      $ret = preg_replace("/\[\s+\]/", "", $ret);
      $ret = preg_replace("/\{\s+\}/", "", $ret);
    }

    if (__CLASS__ && isset($this))
    {
        $_myself = array($this, __FUNCTION__);
    }
    elseif (__CLASS__)
    {
        $_myself = array('self', __FUNCTION__);
    }
    else
    {
        $_myself = __FUNCTION__;
    }

    if (is_null($_escape))
    {
        $_escape = function ($str)
        {
            return str_replace(
                array('\\', '"', "\n", "\r", "\b", "\f", "\t", '\\\\u'),
                array('\\\\', '\\"', "\\n", "\\r", "\\b", "\\f", "\\t", '\\u'),
                $str);
        };
    }

    $out = '';

    // TODO: format value (unicode, slashes, ...)
    if((!is_array($in)) && (!is_object($in)))
      return json_encode($in);

    // see http://stackoverflow.com/a/173479
    $is_assoc = array_keys($in) !== range(0, count($in) -1);

    foreach ($in as $key=>$value)
    {
	if($is_assoc) {
	  $out .= str_repeat($indent_string, $indent + 1);
	  $out .= "\"".$_escape((string)$key)."\": ";
	}
	else {
	  $out .= str_repeat($indent_string, $indent + 1);
	}

	if ((is_object($value) || is_array($value)) && (!count($value))) {
	    $out .= "[]";
	}
        elseif (is_object($value) || is_array($value))
        {
            $out .= call_user_func($_myself, $value, $indent_string, $indent + 1, $_escape);
        }
        elseif (is_bool($value))
        {
            $out .= $value ? 'true' : 'false';
        }
        elseif (is_null($value))
        {
            $out .= 'null';
        }
        elseif (is_string($value))
        {
            $out .= "\"" . $_escape($value) ."\"";
        }
        else
        {
            $out .= $value;
        }

        $out .= ",\n";
    }

    if (!empty($out))
    {
        $out = substr($out, 0, -2);
    }

    if($is_assoc) {
      $out =  "{\n" . $out;
      $out .= "\n" . str_repeat($indent_string, $indent) . "}";
    }
    else {
      $out = "[\n" . $out;
      $out .= "\n" . str_repeat($indent_string, $indent) . "]";
    }

    return $out;
}

register_hook("twig_init", function() {
  global $twig;

  $twig->addFilter(new Twig_SimpleFilter('json_readable_encode', function($data) {
    return json_readable_encode($data);
  }));
});
