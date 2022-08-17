<?php 
  function str_extract($str, $pattern, $get = null, $default = null)
  {
  	$result = [];

  	preg_match($pattern, $str, $matches);

  	preg_match_all('/(\(\?P\<(?P<name>.+)\>\.\+\)+)/U', $pattern, $captures);

  	$names = $captures['name'] ?? [];
  	
  	foreach($names as $name)
  	{
  		$result[$name] = $matches[$name] ?? null;
  	}

  	return $get ? ($result[$get] ?? $default) : $result;
  }

  function wrap_str($str = '', $first_delimiter = "'", $last_delimiter = null)
	{
		if(!$last_delimiter)
		{
			return $first_delimiter.$str.$first_delimiter;
		}

		return $first_delimiter.$str.$last_delimiter;
	}
?>