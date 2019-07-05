<?php
    try {
        require_once './novus.config.php';
		require_once './src/Bootstrapper.php';
        
		$app = new Application();
        $app->run();
	}
	catch (Exception $e) {
		if(IsDebug) {
			echo $e;
		}
		else {
			require_once './src/controllers/ErrorController.php';
			require_once "./src/Enums/HttpStatus.php";
			
			$controller = new ErrorController();
			$controller->renderHttpStatus(HttpStatus::INTERNAL_SERVER_ERROR);
			
			return;
		}
	}

?>
