<?php
    try {
		include_once('./config/database.php');
		include_once('./core/include/init.php');

		$dbh = new PDO('mysql:dbname=' . DB_NAME . ';host='.DB_HOST . '', DB_USER, DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->query('SET NAMES UTF8');

		$sys = new System($dbh);

		echo "<link rel='stylesheet' href='" . ThemeHandler::getFile($dbh, "/styles/style.css") . "'>";
		echo <<<EOT
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<h1>Content-Management-System</h1>
		<a href='./'>Start</a>
		<a href="?action=ThemeHandler">ThemeHandler</a>
		<a href="?action=Article">Article</a>
		<a href="?action=API">API</a>
		<a href="?action=Stats">Stats</a>
		<a href="?action=CH">CalendarHandler</a>
		<hr/>
EOT;

		if(isset($_GET['action'])) {
			switch($_GET['action']) {
				case "ThemeHandler":
					echo "<img src='" . ThemeHandler::getFile($dbh, "/header.jpg") . "' style='width:30%;height:auto'><br/>";

					$dirTheme = "./theme/";
					$dir = scandir($dirTheme);
					$dateiname = "/install.cfg";

					#----------Datei-Interpreter für den ThemeHandler
					for($i = 2; $i < count($dir); $i++) {
						if(file_exists($dirTheme . $dir[$i] . $dateiname)) {
							$data = parse_ini_file($dirTheme . $dir[$i] . $dateiname);

							echo "<pre>";
							print_r($data);
							echo "</pre>";
						}
					}
					#----------
				break;
				case "Article":
					$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
					$prevPage = ($currentPage - 1 > 0) ? $currentPage - 1 : 1;
					$nextPage = $currentPage + 1;
					$aPP = ArticleHandler::getArticlesPerPage($dbh);

					setcookie("cms_articles_per_page", "10");
					$articlesPerPage = isset($_COOKIE["cms_articles_per_page"]) ? $_COOKIE["cms_articles_per_page"] : null;

					echo "<h2>Seite {$currentPage}</h2><h5>{$aPP} Artikel pro Seite<br/>{$articlesPerPage}</h5>";
					echo "<a href='?action=Article&page={$prevPage}'>Vorherige</a>";
					echo "<a href='?action=Article&page={$nextPage}'>Nächste</a>";

					echo "<pre>";
					print_r(ArticleHandler::getAll($currentPage, $articlesPerPage));
					echo "</pre>";
				break;
				case "API":
					$articlesPerPage = isset($_COOKIE["cms_articles_per_page"]) ? $_COOKIE["cms_articles_per_page"] : null;

					echo "<pre>";
					print_r("[WIP]");
					echo "</pre>";
				break;
				case "Stats":
					//System::count_visit();
				break;
				case "CH":
					print_r(CalendarHandler::getEventFromDate(date('Y-m-d')));
				break;
				default:
					echo "<h1>Nix gefunden!</h1>";
				break;

			}
		}
		else {

		}
	}
	catch (Exception $e) {
		echo "<div class='box msg_error'>" . $e->getMessage() . "</div>";
	}

?>
