<?php
	include_once("./core/init.php");

	try {
		echo '<pre>', var_dump(PathFinder::getInstance()->getDirectory()), '</pre>';
		$tc = new Test();
	}
	catch(Exception $e) {
		echo $e->getMessage();
	}
?>
