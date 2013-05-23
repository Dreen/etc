<?php

/**
 * Getting variables from URL string
 * @param string $index Variable name
 * @param string $default Default value if unset
 * @param string $callback apply callback function before returning
 * @return differs
 */
function reqvar($varname, $default=NULL, $callback=NULL, $scope=NULL)
{
  $scope = ($scope === NULL) ? $_GET : $scope;
	
	if (isset($scope[$varname]) && strlen(trim($scope[$varname])) !== 0)
		return ($callback !== NULL) ? $callback($scope[$varname]) : $scope[$varname];
	else
		return $default;
}

/**
 * require elements in an assoc array (default POST)
 */
function checkinput($reference, $scope=NULL)
{
	if ($scope === NULL)
		$scope = $_POST;
	
	for ($i=0, $size=count($reference); $i<$size; $i++)
	{
		if (!isset($scope[$reference[$i]]) || $scope[$reference[$i]] === NULL)
			return false;
		elseif (is_string($scope[$reference[$i]]) && strlen(trim($scope[$reference[$i]])) === 0)
			return false;
	}
	
	return true;
}


/**
 * Search a multi-dimensional array for a value, optionally taking keys into consideration as well.
 * Returns a keyroute for a found element, starting from level 1 array
 * Useful for localising a web user's location in website's sitemap.
 *
 * @param string $needle Search item
 * @param array $heystack Search area
 * @param boolean $conside_keys Search array keys as well
 * @return array
 */
function array_search_recursive_improved ($needle, $heystack, $consider_keys = false)
{
	if (array_key_exists($needle,$heystack) && $consider_keys) // item is in keys
		return array($needle);
	else // search values
	{
		foreach ($heystack as $key => $value)
		{
			if (is_array($value)) // we have an array value, search it
                        {
                                $effect = array_search_recursive_improved($needle,$value);
                                if ($effect == false)
                                        continue;
                                else
                                        return array_merge( array($key), $effect);
                        }
			else	// non-array value
			{
				if ($value == $needle)
					return array($key);
			}
		}
		
		return false;
	}
}


/**
 * Delete empty elements of an array
 * @param array $arr The input
 * @return array
 */
function del_empty($arr)
{
	foreach ($arr as $key => $value)
	{
		if (trim(strval($value))!='')
			$rzygi[$key] = $value;
	}
	return $rzygi;
}

/**
 * Replace links in text with HTML links.
 * @input string $text The input
 * @return string
 */
function hyperlink($text)
{
	$text = ereg_replace("[a-zA-Z]+://([-]*[.]?[a-zA-Z0-9_/-?&%])*", "<a href=\"\\0\">\\0</a>", $text);
	$text = ereg_replace("(^| )(www([-]*[.]?[a-zA-Z0-9_/-?&%])*)", "\\1<a href=\"http://\\2\">\\2</a>", $text);
	return $text;
}

/**
 * List files recursively.
 * @param string $path Begin in this directory. WARNING: $path should NOT have a '/' at the end.
 * @param int $list_types GTS_ALL: list all files; GTS_FILES_ONLY: do not list directories
 * @param int $mode GTS_DEEP: list directories recursively; GTS_SHALLOW: only list given directory
 * @param string $depth Internal parameter, do not use
 * @return array
 */
function getTreeStructure($path, $list_types = GTS_ALL, $mode = GTS_DEEP, $depth = '')
{
	if (is_dir($path) && $dh = opendir($path))
	{
		$rzygi = array();
		
		while(($item = readdir($dh)) !== false)
		{
			if (in_array($item, array('.', '..')))
				continue;
			
			$fullItem = $path . '/' . $item;
			
			if (is_dir($fullItem))
			{
				if ($list_types == GTS_ALL)
					$rzygi[] = $depth . $item;
				
				if ($mode == GTS_DEEP)
					$rzygi = array_merge($rzygi, getTreeStructure($fullItem, $list_types, $mode, $depth . $item . '/'));
			}
			else
				$rzygi[] = $depth . $item;
		}
		closedir($dh);
		return $rzygi;
	}
	
	return false;
}

/**
 * Recursively copy a directory (or a file) to some place.
 * @param string $from Source location
 * @param string $to Destination location (directory only)
 * @param array $skip Do not copy files listed here
 */
function cp_r ($from, $to, $skip = array())
{
	$fromFile = basename($from);
	if (in_array($fromFile,$skip))
		return false;
	
	if (!is_dir($from))
		copy($from, $to . '/' . $fromFile);
	else
	{
		mkdir($to . '/' . $fromFile);
		$dir = array_diff(getTreeStructure($from, GTS_ALL),$skip);
		sort($dir);
		
		for($i=0; $i<count($dir); $i++)
		{
			if (!is_dir($from . '/' . $dir[$i]))
				copy($from . '/' . $dir[$i], $to . $fromFile . '/' . $dir[$i]);
			else
				mkdir($to . $fromFile . '/' . $dir[$i]);
		}
		return true;
	}
}

/**
 * Recursively delete a directory (or a file)
 * @param string $what Item to delete
 */
function rm_r ($what)
{
	if (!is_dir($what))
		unlink($what);
	else
	{
		$dir = getTreeStructure($what, GTS_ALL, GTS_SHALLOW);
		
		for($i=0; $i<count($dir); $i++)
			rm_r($what . '/' . $dir[$i]);
		
		rmdir($what);
	}
}

/* from http://us2.php.net/manual/en/function.chr.php#77911 */
function unichr($c) {
    if ($c <= 0x7F) {
        return chr($c);
    } else if ($c <= 0x7FF) {
        return chr(0xC0 | $c >> 6) . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0xFFFF) {
        return chr(0xE0 | $c >> 12) . chr(0x80 | $c >> 6 & 0x3F)
                                    . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0x10FFFF) {
        return chr(0xF0 | $c >> 18) . chr(0x80 | $c >> 12 & 0x3F)
                                    . chr(0x80 | $c >> 6 & 0x3F)
                                    . chr(0x80 | $c & 0x3F);
    } else {
        return false;
    }
}


?>
