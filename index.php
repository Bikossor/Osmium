<?php
    try {
        require './config.php';
		require './core/init.php';
        
		$app = new Application();
        $app->run();
	}
	catch (Exception $e) {
		echo $e;
	}

?>
