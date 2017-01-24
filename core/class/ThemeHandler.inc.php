<?php
	class ThemeHandler {
		static function get_id(PDO $_dbh) {
			if(class_exists("System")) {
				return System::getSetting($_dbh, "selectedTheme");
			}
			else {
				throw new Exception("Unable to load class \"System\"!", 10);
			}
		}

		static function get_name(PDO $_dbh) {
			$q = mysql_query("SELECT name FROM cms_themes WHERE tid=" . ThemeHandler::get_id($_dbh) . " LIMIT 1");

			return $q; //----------------------------------------------------------------------------------------------------------------

			$d = mysql_fetch_assoc($q);

			return $d['name'];
		}

		static function get_path() {
			if(file_exists("./theme/" . ThemeHandler::get_name())) {
				return "./theme/" . ThemeHandler::get_name();
			}
			else if(file_exists("./theme/default")) {
				return "./theme/default";
			}
			else {
				throw new Exception(__METHOD__);
			}
		}

		static function get_file(PDO $_dbh, $_file) {
			if(file_exists("./theme/" . ThemeHandler::get_name($_dbh) . $_file)) {
				return "./theme/" . ThemeHandler::get_name($_dbh) . $_file;
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
