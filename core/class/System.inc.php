<?php
	/*
		@author:	Andr� Lichtenth�ler
		@copyright:	Andr� Lichtenth�ler, 2016
		@version:	2.0.2
		@since:		1.0.0 First introduced
		@since:		2.0.2 PDO-Utilize
	*/

	class System {
		private $pdo;

		public function __construct(PDO $_pdo) {
			$this->pdo = $_pdo;
		}

		public function getSetting($_property, $_column = 'value') {
			//$sql = $_dbh->prepare("SELECT property, value, added, modified FROM cms_settings WHERE property='{$_property}'");
			//$query = mysql_query($sql);
			//return mysql_fetch_assoc($query)[$_column];
			return 0;
		}

		public function setSetting($_property, $_value) {
			$sql = $this->pdo->prepare('INSERT INTO cms_settings (property, value, added) VALUES (:property, :value, NOW()) ON DUPLICATE KEY UPDATE value=:value, modified=NOW()');
			$sql->execute([
				':property'=>$_property,
				':value'=>$_value
			]);
		}
	}
?>
