<?php
	class Page {
		public function create($_pid, $_added) {
			$this->pid = $_pid;
			$this->added = $_added;

			$createPage = "INSERT INTO cms_pages (`pid`, `title`, `content`, `added`, `modified`) VALUES ('{$this->pid}', NULL, NULL, '{$this->added}', NULL)";

			if(!mysql_query($createPage)) {
				throw new Exception("[PAGE] " . mysql_error());
			}
		}

		public function setupTable() {
			$createTable = "CREATE TABLE IF NOT EXISTS `cms`.`cms_pages` ( `pid` VARCHAR(8) NOT NULL , `title` VARCHAR(100) NULL , `content` TEXT NULL , `added` INT(10) NOT NULL , `modified` INT(10) NULL , PRIMARY KEY (`pid`) ) ENGINE = InnoDB;";
			if(!mysql_query($createTable)){
				throw new Exception("[PAGE] " . mysql_error());
			}
		}

		public function delete() {
			return null;
		}

		public function edit() {
			return null;
		}

		public function setContent() {
			$this->content = print_r($_SERVER);
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
