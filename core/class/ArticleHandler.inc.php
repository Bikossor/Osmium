<?php
	class ArticleHandler implements Iterator, Countable {
		private $index = 0;
		private $count = 0;
		private $article = [];
		private $dbh;

		function __construct(PDO $_dbh) {
			$this->dbh = $_dbh;

			$sql = "SELECT title, cms_user.name AS 'author', content, DATE_FORMAT(created, '%d.%m.%Y') AS created, DATE_FORMAT(last_modified, '%d.%m.%Y') AS last_modified FROM cms_articles LEFT JOIN cms_user ON cms_articles.author=cms_user.id WHERE status=0";

			if($sth = $this->dbh->query($sql)) {
				$this->count = $sth->rowCount();

				if($this->count > 0) {
					$this->article = $sth->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			else {
				throw new PDOException(sprintf("PDO error at %s:%s", __CLASS__, __LINE__));
			}
		}

		public function current() {
			return $this->article[$this->index];
		}

		public function next() {
			$this->index++;
		}

		public function key() {
			return $this->index;
		}

		public function valid() {
			return isset($this->article[$this->index]);
		}

		public function rewind() {
			$this->index = 0;
		}

		public function count() {
			return $this->count;
		}

		public function getByTitle($_title) {
			for($i = 0; $i <= $this->count; $i++) {
				if($this->article[$i]['title'] == $_title) {
					return $this->article[$i];
				}
			}
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

		static public function getAll($_page = 1, $_articlesPerPage) { // TODO: NEW
			if($_articlesPerPage === null) {
				$_articlesPerPage = System::getSetting($this->$dbh, "articlesPerPage");
			}

			$offset = ($_page - 1) * $_articlesPerPage;
			$query = "SELECT aid, title, content, added FROM cms_articles LIMIT {$offset}, {$_articlesPerPage}";

			if($d = mysql_query($query)) {
				$res = [];

				if(mysql_num_rows($d) > 0) {
					while($data = mysql_fetch_assoc($d)) {
						array_push($res, $data);
					}
					return $res;
				}
				else {
					throw new Exception("Keine weiteren Artikel vorhanden!");
				}
			}
			else {
				throw new Exception(mysql_error(), 1);
			}
		}

		static public function write($_title, $_content) { // TODO: NEW
			if(!mysql_query("INSERT INTO cms_articles (aid, title, content, added) VALUES (NULL, '{$_title}', '{$_content}', NOW())")) {
				throw new Exception(__METHOD__ . " - " . mysql_error());
			}
		}
	}
?>
