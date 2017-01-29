<?php
	class ThemeHandler {
		static function getId(PDO $_dbh) {
			if(class_exists("System")) {
				return System::getSetting($_dbh, "selectedTheme");
			}
			else {
				throw new Exception("Unable to load class \"System\"!", 10);
			}
		}

		static function getName(PDO $_dbh) {
			$q = mysql_query("SELECT name FROM cms_themes WHERE tid=" . ThemeHandler::getId($_dbh) . " LIMIT 1");

			return $q;

			$d = mysql_fetch_assoc($q);

			return $d['name'];
		}

		static function getPath() {
			if(file_exists("./theme/" . ThemeHandler::getName())) {
				return "./theme/" . ThemeHandler::getName();
			}
			else if(file_exists("./theme/default")) {
				return "./theme/default";
			}
			else {
				throw new Exception(__METHOD__);
			}
		}

		static function getFile(PDO $_dbh, $_file) {
			if(file_exists("./theme/" . ThemeHandler::getName($_dbh) . $_file)) {
				return "./theme/" . ThemeHandler::getName($_dbh) . $_file;
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
