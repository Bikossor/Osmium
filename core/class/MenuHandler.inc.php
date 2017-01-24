<?php
	/*
		@author:	André Lichtenthäler
		@copyright:	André Lichtenthäler, 2016
		@version:	1.7.5
		@since:		1.0.0 First introduced
	*/
	
	class MenuHandler implements Iterator, Countable, jsonSerializable {
		private $author = "André Lichtenthäler";
		private $creation_date = "29.03.2016";
		private $modification_date;
		private $major_release = 1;
		private $minor_release = 7;
		private $patch_level = 5;
		
		private $name;
		private $index = 0;
		private $counter = 0;
		private $menu = [];
		
		function __construct($_name) {
			$this->name = mysql_real_escape_string($_name);
			$sql = sprintf("SELECT title, href FROM menu_items WHERE menu='%s' ORDER BY position ASC", $this->name);
			$query = mysql_query($sql);
			$this->counter = mysql_num_rows($query);
			
			if($this->counter > 0) {
				while($data = mysql_fetch_assoc($query)) {
					$this->menu[] = ['title'=>$data['title'],'href'=>$data['href']];
				}
			}
			else {
				throw new Exception(sprintf("[%s](%s): Kein Menü vorhanden!", __CLASS__, __LINE__));
			}
		}
		
		public function jsonSerialize() {
			return $this->menu;
		}
		
		public function current() {
			return $this->menu[$this->index];
		}
		
		public function next() {
			$this->index++;
		}
		
		public function key() {
			return $this->index;
		}
		
		public function valid() {
			return isset($this->menu[$this->index]);
		}
		
		public function rewind() {
			$this->index = 0;
		}
		
		public function count() {
			return $this->counter;
		}
		
		public function getAuthor() {
			return $this->author;
		}
		
		public function getCreationDate() {
			$this->creation_date = new DateTime($this->creation_date);
			
			return $this->creation_date;
		}
		
		public function getModificationDate() {
			$this->modification_date = new DateTime(date('d.m.Y', filemtime(__FILE__)));

			return $this->modification_date;
		}
		
		public function getVersion() {
			return sprintf('%d.%d.%d', $this->major_release, $this->minor_release, $this->patch_level);
		}
	}
?>