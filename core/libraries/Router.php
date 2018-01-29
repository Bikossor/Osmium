<?php
	class Router {
		private $_uri = [];

		public function add($uri, $callback) {
			$this->_uri[$uri] = $callback;
		}

		public function route() {
			$url = isset($_GET['uri']) ? rtrim('/' . $_GET['uri'], '/') : '/';

			if(array_key_exists($url, $this->_uri)) {
				$this->_uri[$url]();
			}
		}
	}

?>
