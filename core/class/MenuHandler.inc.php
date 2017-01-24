<?php
	class MenuHandler implements Iterator, Countable {
		private $name;
		private $item = [];

		private $index = 0;
		private $count = 0;

		private $dbh;

		function __construct(PDO $_dbh, $_name) {
			$this->dbh = $_dbh;
			$this->name = mysql_real_escape_string($_name);

			$sql = sprintf("SELECT title, href FROM menu_items WHERE menu='%s' ORDER BY position ASC", $this->name);
			$query = mysql_query($sql);
			$this->count = mysql_num_rows($query);
			
			if($this->count > 0) {
				while($data = mysql_fetch_assoc($query)) {
					$this->item[] = [
						'title'=>$data['title'],
						'href'=>$data['href']
					];
				}
			}
			else {
				throw new Exception(sprintf("[%s](%s): Kein Menü vorhanden!", __CLASS__, __LINE__));
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
