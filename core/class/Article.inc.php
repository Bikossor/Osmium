<?php
	class Article {
		public $aid;
		public $title;
		public $title_sdx;
		public $content;
		public $created;
		public $last_modified;
		public $status;
		public $author;

		public function toJSON() {
			return json_encode($this);
		}
	}
?>
