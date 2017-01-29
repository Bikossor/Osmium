<?php
	class ArticleHandler implements Iterator, Countable {
		private $index = 0;
		private $counter = 0;
		private $articles = [];
		private $dbh;

		function __construct(PDO $_dbh) {
			mysql_query("SET NAMES UTF8");
			$sql = "SELECT title, user.name AS 'author', content, DATE_FORMAT(created, '%d.%m.%Y') AS created, DATE_FORMAT(last_modified,'%d.%m.%Y') AS last_modified FROM article INNER JOIN user ON article.author=user.id WHERE status=0";
			$query = mysql_query($sql);

			$this->counter = mysql_num_rows($query);
			$this->dbh = $_dbh;

			if($this->counter > 0) {
				while($data = mysql_fetch_assoc($query)) {
					$this->articles[] = ['title'=>$data['title'],'author'=>$data['author'],'content'=>$data['content'],'created'=>$data['created'],'last_modified'=>$data['last_modified']];
				}
			}
			else {
				throw new Exception(sprintf("[%s](%s): Keine Artikel vorhanden!", __CLASS__, __LINE__));
			}
		}

		public function current() {
			return $this->articles[$this->index];
		}

		public function next() {
			$this->index++;
		}

		public function key() {
			return $this->index;
		}

		public function valid() {
			return isset($this->articles[$this->index]);
		}

		public function rewind() {
			$this->index = 0;
		}

		public function count() {
			return $this->counter;
		}

		public function getByTitle($_title) {
			for($i = 0; $i <= $this->counter; $i++) {
				if($this->articles[$i]['title'] == $_title) {
					return $this->articles[$i];
				}
			}
		}

		public function setupTable() {
			$sql = "CREATE TABLE IF NOT EXISTS `article` (
				`title` varchar(100) NOT NULL,
				`title_sdx` varchar(7) NOT NULL,
				`content` text NOT NULL,
				`created` date NOT NULL,
				`last_modified` date NULL,
				`status` int(1) UNSIGNED NOT NULL,
				`author` int(10) UNSIGNED NOT NULL,
				PRIMARY KEY (`title`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

			if(!mysql_query($sql)) {
				throw new Exception(sprintf("<p>[%s](%s): Tabelle konnte nicht erstellt werden!</p>", __CLASS__, __LINE__));
			}
		}

		static public function getAll($_page = 1, $_articlesPerPage) {
			if($_articlesPerPage === null) {
				//$_articlesPerPage = System::getSetting($this->$dbh, "articlesPerPage");
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

		static public function getArticlesPerPage(PDO $_dbh) {
			return System::getSetting($_dbh, "articlesPerPage");
		}

		static public function write($_title, $_content) {
			if(!mysql_query("INSERT INTO cms_articles (aid, title, content, added) VALUES (NULL, '{$_title}', '{$_content}', NOW())")) {
				throw new Exception(__METHOD__ . " - " . mysql_error());
			}
		}
	}
?>
