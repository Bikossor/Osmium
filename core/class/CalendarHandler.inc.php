<?php
	class CalendarHandler {
		static function getEventFromDate($_date) {
			$sql = "SELECT event FROM cms_calendar WHERE date='{$_date}'";

			$query = mysql_query($sql);
			return mysql_fetch_assoc($query);
		}
	}
?>
