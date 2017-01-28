<?php
	class System {
		public function __construct(PDO $_dbh) {
			$this->dbh = $_dbh;
		}

		public function getSetting($_property, $_column = 'value') {
			$sth = $this->dbh->prepare('SELECT property, value, added, modified FROM cms_settings WHERE property=:property')
			$sth->execute([
				':property'=>$_property
			]);

			return $sth->fetch(PDO::FETCH_ASSOC)[$_column];
		}

		public function setSetting($_property, $_value) {
			$sth = $this->dbh->prepare('INSERT INTO cms_settings (property, value, added) VALUES (:property, :value, NOW()) ON DUPLICATE KEY UPDATE value=:value, modified=NOW()');
			$sth->execute([
				':property'=>$_property,
				':value'=>$_value
			]);
		}
	}
?>
