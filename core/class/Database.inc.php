<?php
	/*
		@author:	André Lichtenthäler
		@copyright:	André Lichtenthäler, 2016
		@version:	1.0.0
		@since:		1.0.0 First introduced
		
		@todo: Löschen, weil PDO genutzt werden soll.
	*/
	
	class Database extends mysqli {
		//TODO: mysqli vernünftig implementieren und Klasse aufräumen.
		private $host; /* Adresse des DB-Servers */
		private $user; /* Benutername */
		private $pass; /* Passwort */
		private $database; /* Name der Datenbank */
		
	  	public function connect($_host, $_user, $_pass, $_db) {
			$this->host = $_host;
			$this->user = $_user;
			$this->pass = $_pass;
			$this->database = $_db;
			
			if(!mysql_connect($this->host, $this->user, $this->pass)) {
				throw new Exception("[Database]: Unable to connect to server!");
			}
			if(!mysql_select_db($this->database)) {
				throw new Exception("[Database]: Unable to select database!");
			}
			
			mysql_query("SET NAMES UTF8");
		}
	  	
		public function disconnect() {
			if(!mysql_close()) {
				throw new Exception("[Database]: Unable to disconnect from server!");
			}
		}
		
	  	public function query($_k) {
	  		$res = mysql_query($_k);
	  		
	  		if($res) {
	  			return $res;
	  		}
	  		else {
	  			throw new Exception("[Database]: Unable to query! (${_k})");
	  		}
	  	}
	  	
	  	public function fetch_assoc($_k) {
	  		$res = mysql_fetch_assoc($_k);

	  		if($res) {
	  			return $res;
	  		}
	  		else {
	  			throw new Exception("[Database]: Unable to fetch! (${_k})");
	  		}
	  	}
	  	
	  	public function fetch_assoc_all($_k) {
	  		$res = [];
	  		$count = mysql_num_rows($_k);

	  		if($count > 0) {
	  			while ($item = mysql_fetch_assoc($_k)) {
	  				array_push($res, $item);
	  			}
	  		}
	  		return $res;
	  	}
		
	  	public function getStats() {
			return explode('  ', mysql_stat());
	  	}
	}
?>