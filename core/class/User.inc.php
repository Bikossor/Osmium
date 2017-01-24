<?php
	class User {
		protected $_table = "cms_user";
		protected $_name;

		public function __construct($str) {
			$this->_name = $str;
		}

		public function save(PDO $dbh) {
			$sth = $dbh->prepare("INSERT IGNORE INTO cms_user (name, added) VALUES (:name, NOW())");
			$sth->execute([
				':name' => $this->_name
			]);
		}
	}
?>
