<?php
    try {
        require './novus.config.php';
		require './core/Bootstrapper.php';
        
		$app = new Application();
        $app->run();
	}
	catch (Exception $e) {
		echo $e;
	}

?>
