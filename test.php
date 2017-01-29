<?php
	include_once("./core/class/MenuHandler.inc.php");
	include_once("./core/class/System.inc.php");

	try {
		$dbh = new PDO('mysql:host=localhost;dbname=cms', 'root', '');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->query("SET NAMES UTF8");

		$menu = new MenuHandler($dbh, "Test");

		foreach ($menu as $item) {
			echo $item['title'];
		}

		var_dump(System::setSetting($dbh, "dwawddwa", 0));

		/*
		if(!(isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == 1)) {
			if(!isset($_COOKIE['Visitor'])) {
				setCookie("Visitor", "1");
				$dbh->query("INSERT INTO cms_views (id, date, time) VALUES (NULL, CURRENT_DATE(), CURRENT_TIME())");
				echo "Ausgeführt!";
			}
		}
		else {
			echo "Dein Aufruf wurde nicht aufgezeichnet!";
		}
		*/
	}
	catch(Exception $e) {
		echo $e->getMessage();
	}
?>
