<?php
include_once('./core/include/init.php');

try {
	$dbh = new PDO('mysql:host=localhost;dbname=cms', 'root', '');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->query("SET NAMES UTF8");

	$u1 = new User("André");
	$u1->save($dbh);

	$u2 = new User("Marvin");
	$u2->save($dbh);
	
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

	/*
	$sql = $dbh->prepare("SELECT COUNT(id) AS 'views_total' FROM cms_views");
	$sql->execute();
	$res = $sql->fetch();

	echo "Du bist der " . ($res['views_total'] + 1) . ". Besucher!";
	*/
}
catch(Exception $e) {
	echo $e->getMessage();
}
