<?php
	class ArticleHandler {
		private $dbh;
		private $limit;

		function __construct(PDO $_dbh) {
			$this->dbh = $_dbh;

			if(class_exists('System')) {
				$this->limit = (int)System::getSetting($this->dbh, 'articleLimit');
			}
			else {
				throw new Exception("System-Class was not found by " . __CLASS__);
			}
		}

		public function setupTable() {
			$sql = $this->dbh->query("CREATE TABLE IF NOT EXISTS `cms_articles` (
				`aid` varchar(50) NOT NULL,
				`title` varchar(100) NOT NULL,
				`title_sdx` varchar(7) NOT NULL,
				`content` text NOT NULL,
				`created` datetime NOT NULL,
				`last_modified` datetime NULL,
				`status` int(1) UNSIGNED NOT NULL,
				`author` int(10) UNSIGNED NOT NULL,
				PRIMARY KEY (`aid`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

			if($sql) {
				return true;
			}
			else {
				throw new PDOException(sprintf("<p>[%s](%s): Tabelle konnte nicht erstellt werden!</p>", __CLASS__, __LINE__));
				return false;
			}
		}

		public function getAll($_page = 1) {
			if(!empty($_page) && is_numeric($_page)) {
				$offset = ($_page - 1) * $this->limit;

				$sth = $this->dbh->prepare("SELECT aid, title, title_sdx, content, created, last_modified, status, author FROM cms_articles ORDER BY aid LIMIT :offset, :limit");
				$sth->bindParam(':limit', $this->limit, PDO::PARAM_INT);
				$sth->bindParam(':offset', $offset, PDO::PARAM_INT);
				$sth->execute();

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
			else {
				throw new InvalidArgumentException(sprintf("Invalid argument at %s:%s", __CLASS__, __LINE__));
				return false;
			}
		}
	}
?>
