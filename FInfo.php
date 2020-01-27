<?php
namespace FInfo;
class FInfo
{
	public static function mime_content_type($file)
	{
		$ext=strtolower(substr(strrchr(basename($file), '.'),1));
		switch ( $ext )
		{
		   case 'csv':	return 'text/csv';
		   case 'html':	return 'text/html';
		   case 'javascript':	return 'text/js';
		   case 'txt':	return 'text/plain';
		   case 'php':	return 'text/php';
		   case 'xml':	return 'text/xml';
		   case 'markdown':	return 'text/plain';
		   default:     return 'forbidden';
		}
	}
}