<?php
    try {
		include_once('./config/database.php');
		include_once('./core/init.php');

		$dbh = new PDO('mysql:dbname=' . DB_NAME . ';host='.DB_HOST . '', DB_USER, DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->query('SET NAMES UTF8');

		$sys = new System($dbh);
		$th = new ThemeHandler($dbh);
	?>
		<link rel="stylesheet" href="<?php echo $th->getFile("/styles/style.css"); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<h1>Content-Management-System</h1>
		<a href="./">Start</a>
		<a href="?action=ThemeHandler">ThemeHandler</a>
		<a href="?action=Article">Article</a>
		<a href="?action=CH">CalendarHandler</a>
		<a href="?action=System">System</a>
		<hr/>
	<?php
		if(isset($_GET['action'])) {
			switch($_GET['action']) {
				case "ThemeHandler":
					echo "<img src='" . $th->getFile("/header.jpg") . "' style='width:30%;height:auto'><br/>";

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
					$ah = new ArticleHandler($dbh);
					$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
					$prevPage = ($currentPage - 1 > 0) ? $currentPage - 1 : 1;
					$nextPage = $currentPage + 1;

					echo "<h2>Seite {$currentPage}</h2>";
					echo "<a href='?action=Article&page={$prevPage}'>Vorherige</a>";
					echo "<a href='?action=Article&page={$nextPage}'>Nächste</a><br>";

					foreach($ah->getAll($currentPage) as $article)
					{
					    echo $article->toJSON(), "<br>";
					}
				break;
				case "CH":
					print_r(CalendarHandler::getEventFromDate(date('Y-m-d')));
				break;
				case "System":

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
		echo "<div class='box msg_error'>", $e->getMessage(), "</div>";
	}

?>
