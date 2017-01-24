<h1>Admin-Dashboard</h1>
<?php
	try {
		include_once("../config/database.php");
		include_once("../core/class/database.php");
		include_once("../core/class/system.php");
		include_once("../core/class/themeHandler.php");
		include_once("../core/class/articleHandler.php");
		include_once("../core/class/page.php");
		include_once("../core/class/enviroment.php");

		$db = new Database();
		$db->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		ArticleHandler::get_form($_SERVER['QUERY_STRING']);

		if(isset($_POST['ah_BtnSave'])) {
			ArticleHandler::write($_POST['ah_Title'], $_POST['ah_Content']);
		}

		$sql = "SELECT property, value, DATE_FORMAT(added, '%d.%m.%Y - %H:%i') AS 'added', DATE_FORMAT(modified, '%d.%m.%Y - %H:%i') AS 'modified' FROM cms_settings";
		$query = mysql_query($sql);
		
		echo "<table>";
		if(mysql_num_rows($query) > 0) {
			while($data = mysql_fetch_assoc($query)) {
				echo "<tr><td>{$data['property']}</td><td><input type='text' value='{$data['value']}'/></td><td>{$data['added']}</td><td>{$data['modified']}</td></tr>";
			}
		}
		echo "</table>";
	}
	catch (Exception $e) {
		echo "<div class='cms_msg_error'>" . $e->getMessage() . "</div>";
		if($e->getCode() == 1) { ArticleHandler::setup(); }
	}
?>
