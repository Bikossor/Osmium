<?php
	spl_autoload_register(function($name) {
		$path_core = sprintf('./core/class/%s.inc.php', $name);
		$path_module = sprintf('./module/%s.zip', $name);

		if(file_exists($path_core)) {
			require $path_core;
		}
		elseif(file_exists($path_module)) {
			$archive = new ZipArchive();
			if($archive->open($path_module) === true) {
				$tmp = tmpfile();
				$metadata = stream_get_meta_data($tmp);

				file_put_contents($metadata['uri'], $archive->getFromName('main.php'));
				include $metadata['uri'];
			}

		}
		else {
			throw new Exception(sprintf("Files for class '%s' not found!", $name));
		}
	});
?>
