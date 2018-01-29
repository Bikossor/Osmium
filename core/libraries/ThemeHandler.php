<?php
	class ThemeHandler {
		private $dbh;
		private $name;

		function __construct(PDO $_dbh) {
			$this->dbh = $_dbh;

			if(class_exists("System")) {
				$this->name = System::getSetting($_dbh, "selectedTheme");
			}
			else {
				throw new Exception("Unable to load class \"System\"!", 10);
			}
		}

		function getPath() {
			if(file_exists("./theme/" . $this->name)) {
				return "./theme/" . $this->name;
			}
			else if(file_exists("./theme/default")) {
				return "./theme/default";
			}
			else {
				throw new Exception(__METHOD__);
			}
		}

		function getFile($_file) {
			if(file_exists("./theme/" . $this->name . $_file)) {
				return "./theme/" . $this->name . $_file;
			}
			else if(file_exists("./theme/default" . $_file)) {
				return "./theme/default" . $_file;
			}
			else {
				throw new Exception(__METHOD__);
			}
		}
	}
?>
