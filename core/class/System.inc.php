<?php
	class System {
		public static function getSetting(PDO $_dbh, $_property, $_column = 'value') {
			if(!empty($_property) && is_scalar($_property) && !empty($_column) && is_scalar($_column)) {
				$sth = $_dbh->prepare('SELECT property, value, added, modified FROM cms_settings WHERE property=:property');
				$sth->execute([':property' => $_property]);

				return $sth->fetch(PDO::FETCH_ASSOC)[$_column];
			}
			else {
				throw new InvalidArgumentException(sprintf("Invalid argument at %s:%s", __CLASS__, __LINE__));
			}
		}

		public static function setSetting(PDO $_dbh, $_property, $_value) {
			if(!empty($_property) && is_scalar($_property) && is_scalar($_value)) {
				$sth = $_dbh->prepare('INSERT INTO cms_settings (property, value, added) VALUES (:property, :value, NOW()) ON DUPLICATE KEY UPDATE value=:value, modified=NOW()');

				if($sth->execute([':property' => $_property, ':value' => $_value])) {
					return true;
				}
				else {
					throw new PDOException(sprintf("PDO error at %s:%s", __CLASS__, __LINE__));
					return false;
				}
			}
			else {
				throw new InvalidArgumentException(sprintf("Invalid argument at %s:%s", __CLASS__, __LINE__));
			}
		}
	}
?>
