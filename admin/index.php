<h1>Admin-Dashboard</h1>
<?php
	try {
		include_once("../config/database.php");
		require '../core/init.php';

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
		if($e->getCode() == 1) {
			ArticleHandler::setup();
		}
	}
?>
