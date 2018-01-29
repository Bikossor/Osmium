<?php
	class PathFinder {
		private static $instance;
		private function __construct() { }

		public static function getInstance() {
			if(is_null(self::$instance)) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		function getDirectory() {
			return pathinfo(join(array($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'])));
		}
	}
?>
