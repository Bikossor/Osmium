<?php
	spl_autoload_register(function ($name) {
		$file = sprintf('./core/class/%s.inc.php', $name);

		if(file_exists($file)) {
			require $file;
			return true;
		}
		else {
			throw new Exception(sprintf("Files for class '%s' not found!", $name));
			return false;
		}
	});
?>
