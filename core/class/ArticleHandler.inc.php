<?php
	/*
		@author:	André Lichtenthäler
		@copyright:	André Lichtenthäler, 2016
		@version:	1.3.3
		@since:		1.0.0 First introduced
	*/
	
	class ArticleHandler implements Iterator, Countable, jsonSerializable {
		private $author = "André Lichtenthäler";
		private $creation_date = "23.01.2016";
		private $modification_date;
		private $major_release = 1;
		private $minor_release = 3;
		private $patch_level = 3;
		
		private $index = 0;
		private $counter = 0;
		private $articles = [];
		
		function __construct() {
			mysql_query("SET NAMES UTF8");
			$sql = "SELECT title, user.name AS 'author', content, DATE_FORMAT(created, '%d.%m.%Y') AS created, DATE_FORMAT(last_modified,'%d.%m.%Y') AS last_modified FROM article INNER JOIN user ON article.author=user.id WHERE status=0";
			$query = mysql_query($sql);
			$this->counter = mysql_num_rows($query);
			
			if($this->counter > 0) {
				while($data = mysql_fetch_assoc($query)) {
					$this->articles[] = ['title'=>$data['title'],'author'=>$data['author'],'content'=>$data['content'],'created'=>$data['created'],'last_modified'=>$data['last_modified']];
				}
			}
			else {
				throw new Exception(sprintf("[%s](%s): Keine Artikel vorhanden!", __CLASS__, __LINE__));
			}
		}
		
		public function jsonSerialize() {
			return $this->articles;
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
		
		public function getAuthor() {
			return $this->author;
		}
		
		public function getCreationDate() {
			if(!isset($this->creation_date)) {
				$this->creation_date = new DateTime($this->creation_date);
			}
			
			return $this->creation_date;
		}
		
		public function getModificationDate() {
			if(!isset($this->modification_date)) {
				$this->modification_date = new DateTime(date('d.m.Y', filemtime(__FILE__)));
			}
			
			return $this->modification_date;
		}
		
		public function getVersion() {
			return sprintf('%d.%d.%d', $this->major_release, $this->minor_release, $this->patch_level);
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
		
		static public function getAll(PDO $_dbh, $_page = 1, $_articlesPerPage) {
			if($_articlesPerPage === null) {
				$_articlesPerPage = System::getSetting($_dbh, "articlesPerPage");
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
		
		static public function get_form($_action) {
			echo <<<EOT
			<form action="{$_action}" method="POST">
			<input type="text" name="ah_Title"/><br/>
			<textarea name="ah_Content"></textarea><br/>
			<input type="submit" name="ah_BtnSave"/>
			</form>
EOT;
		}
		
		static public function write($_title, $_content) {
			if(!mysql_query("INSERT INTO cms_articles (aid, title, content, added) VALUES (NULL, '{$_title}', '{$_content}', NOW())")) {
				throw new Exception(__METHOD__ . " - " . mysql_error());
			}
		}
	}
?>