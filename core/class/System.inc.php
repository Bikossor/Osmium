<?php
	// TODO: Statisch?

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
