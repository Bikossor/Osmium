<?php

try {
	require_once './osmium.config.php';
	require_once './Osmium/Bootstrapper.php';

	$app = new \Osmium\Core\Application();
	$app->run();
} catch (Exception $e) {
	if (IsDebug) {
		echo $e;
	} else {
		$controller = new \Osmium\Controller\ErrorController();
		$controller->renderHttpStatus(\Osmium\Enum\HttpStatus::INTERNAL_SERVER_ERROR);

		return;
	}
}
