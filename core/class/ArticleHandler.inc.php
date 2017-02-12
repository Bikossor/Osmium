<?php
	class ArticleHandler {
		private $dbh;

		function __construct(PDO $_dbh) {
			$this->dbh = $_dbh;
		}

		public function setupTable() {
			$sql = $this->dbh->query("CREATE TABLE IF NOT EXISTS `cms_articles` (
				`title` varchar(100) NOT NULL,
				`title_sdx` varchar(7) NOT NULL,
				`content` text NOT NULL,
				`created` date NOT NULL,
				`last_modified` date NULL,
				`status` int(1) UNSIGNED NOT NULL,
				`author` int(10) UNSIGNED NOT NULL,
				PRIMARY KEY (`title`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

			if($sql) {
				return true;
			}
			else {
				throw new PDOException(sprintf("<p>[%s](%s): Tabelle konnte nicht erstellt werden!</p>", __CLASS__, __LINE__));
				return false;
			}
		}

		public function getAll() {
			$sth = $this->dbh->query('SELECT title, title_sdx, content, created, last_modified, status, author FROM cms_articles ORDER BY created DESC');

			if($sth) {
				if($sth->rowCount() > 0) {
					return $sth->fetchAll(PDO::FETCH_CLASS, "Article");
				}
				else {
					throw new Exception("No articles found!");
					return false;
				}
			}
			else {
				throw new PDOException(__METHOD__);
				return false;
			}
		}
	}
?>
