<?php
	$start = microtime();
	$dirs = [
		"../admin/",
		"../config/",
		"../config/lang/",
		"../src/",
		"../src/controller/",
		"../src/library/",
		"../src/model/",
		"../src/view/",
		"../storage/",
		"../module/"
	];

	$dir_status = [];

	foreach($dirs as $dir) {
		if(!is_dir($dir)) {
			if(!mkdir($dir)) {
				$dir_status[] = [$dir, 'konnte nicht angelegt werden!', NULL];
			}
			else {
				$dir_status[] = [$dir, 'Angelegt', NULL];
			}
		}
		else {
			$content = implode("<br/>", array_slice(scandir($dir), 2));
			$dir_status[] = [$dir, 'Vorhanden', $content];
		}
	}

	echo "<table border='1'><tr><th>Ordner</th><th>Status</th><th>Content</th></tr>";

	foreach($dir_status as $item) {
		echo "<tr><td style='padding:8px'>{$item[0]}</td><td style='padding:8px'>{$item[1]}</td><td style='padding:8px'>{$item[2]}</td></tr>";
	}

	echo "</table>";
	echo "<div style='position:fixed;left:0;bottom:0;width:100%;height:24px;line-height:24px;color:#0f0;background:#000'>[Benchmark] Dauer: " . number_format(microtime() - $start, 4) . " Sekunden</div>";
?>
