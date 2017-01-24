<?php
	class Page {
		private $pid = null;
		private $title = "DEFAULT";
		private $charset = "UTF-8";
		private $language = "de";
		private $description; // <--Soll in der Datenbank nullable sein; wenn null kein meta-Tag erstellen (weil Google Text aus dem Content nimmt, wenn keine "description" vorhanden ist).
		private $author = "André Lichtenthäler";
		private $robots;
		private $content;
		
		function __construct() {
			$createTable = "CREATE TABLE IF NOT EXISTS `cms`.`cms_pages` ( `pid` VARCHAR(8) NOT NULL , `title` VARCHAR(100) NULL , `content` TEXT NULL , `added` INT(10) NOT NULL , `modified` INT(10) NULL , PRIMARY KEY (`pid`) ) ENGINE = InnoDB;";
			if(!mysql_query($createTable)){
				throw new Exception("[PAGE] " . mysql_error());
			}
		}

		public function create($_pid, $_added) {
			$this->pid = $_pid;
			$this->added = $_added;

			$createPage = "INSERT INTO cms_pages (`pid`, `title`, `content`, `added`, `modified`) VALUES ('{$this->pid}', NULL, NULL, '{$this->added}', NULL)";

			if(!mysql_query($createPage)){
				throw new Exception("[PAGE] "  .mysql_error());
			}
		}

		public function delete() {
			return null;
		}

		public function edit() {
			return null;
		}

		public function setContent() {
			$tthis->content = print_r($_SERVER);
		}

		public function show() {
			echo <<<EOT
<!DOCTYPE HTML>
<html lang="{$this->language}">
	<head>
		<title>{$this->title}</title>
		<meta charset="{$this->charset}">
	</head>
	<body>
	{$this->content}
	</body>
</html>
EOT;
		}
	}
?>
