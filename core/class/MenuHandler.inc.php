<?php
	class MenuHandler implements Iterator, Countable {
		private $name;
		private $item = [];
		private $index = 0;
		private $count = 0;
		private $dbh;

		function __construct(PDO $_dbh, $_name) {
			$this->dbh = $_dbh;
			$this->name = $_name;

			$sth = $this->dbh->prepare('SELECT title, href FROM menu_items WHERE menu=:name ORDER BY position');
			$sth->execute([':name' => $this->name]);

			$this->count = $sth->rowCount();

			if($this->count > 0) {
				$this->item = $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			else {
				throw new Exception(sprintf("[%s](%s): Kein Einträge vorhanden!", __CLASS__, __LINE__));
			}
		}

		public function current() {
			return $this->item[$this->index];
		}

		public function next() {
			$this->index++;
		}

		public function key() {
			return $this->index;
		}

		public function valid() {
			return isset($this->item[$this->index]);
		}

		public function rewind() {
			$this->index = 0;
		}

		public function count() {
			return $this->count;
		}
	}
?>
