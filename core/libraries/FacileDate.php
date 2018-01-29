<?php
	/**
	 * A static class which can format a date diff to a good readable string.
	 */
	class FacileDate {
		public static function format(DateTime $dt1, DateTime $dt2) {
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			$cfg = parse_ini_file(sprintf("./config/lang/%s.ini", $lang));
			$dd = $dt1->diff($dt2);

			if($dd->days == 0 && $dd->h == 0 && $dd->i == 0 && $dd->s <= 59) {
				return sprintf($cfg['str_seconds'], $dd->s);
			}
			else if($dd->days == 0 && $dd->h == 0 && $dd->i <= 59) {
				return sprintf($cfg['str_minutes'], $dd->i);
			}
			else if($dd->days == 0 && $dd->h <= 23) {
				return sprintf($cfg['str_hours'], $dd->h);
			}
			else if($dd->days == 1) {
				return $cfg['str_yesterday'];
			}
			else if ($dd->days > 1 && $dd->days < 7) {
				return $cfg['str_weekday'][$dt2->format('N')];
			}
			else {
				return $dt2->format($cfg['str_default_format']);
			}
		}
	}
?>
