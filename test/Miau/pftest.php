<?php
	class PathFinder
	{
		static function getDirectory() {
			return pathinfo(join(array($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'])));
		}
	}
	
	try {
		echo '<pre>', var_dump(PathFinder::getDirectory()), '</pre>';
	}
	catch(Exception $e) {
		echo $e->getMessage();
	}
?>
