<?php
	/*
		@author:	André Lichtenthäler
		@copyright:	André Lichtenthäler, 2016
		@version:	1.0.0
		@since:		1.0.0 First introduced
	*/
	
	class CalendarHandler {
		static function getEventFromDate($_date) {
			$sql = "SELECT event FROM cms_calendar WHERE date='{$_date}'";
			
			$query = mysql_query($sql);
			return mysql_fetch_assoc($query);
		}
		
		
	}
?>