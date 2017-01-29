<?php
	include_once("./core/init.php");

	try {
		$dbh = new PDO('mysql:host=localhost;dbname=cms', 'root', '');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->query("SET NAMES UTF8");

		$menu = new MenuHandler($dbh, "Test");

		foreach ($menu as $item) {
			echo $item['title'];
		}

		$ah = new ArticleHandler($dbh);
		foreach ($ah as $item) {
			echo "<pre>", var_dump($item), "</pre>";
		}

		var_dump(System::setSetting($dbh, "dwawddwa", 0));
	}
	catch(Exception $e) {
		echo $e->getMessage();
	}
?>
