<?php
require_once './src/libraries/Controller.php';
require_once './src/exceptions/ControllerException.php';

class Application
{
    public function __construct()
    {}

    public function run(): void
    {
        $sanitizedUri = filter_input(INPUT_GET, 'uri', FILTER_SANITIZE_URL);
        $trimmedUri = rtrim($sanitizedUri, '/');
        $uriComponent = explode('/', $trimmedUri);

        $targetController = !empty($uriComponent[0]) ? $uriComponent[0] : 'Index';
        $targetMethod = !empty($uriComponent[1]) ? $uriComponent[1] : 'Index';
        $targetArguments = !empty($uriComponent[2]) ? $uriComponent[2] : null;

        $nameController = $targetController . 'Controller';
        $pathController = './src/controllers/' . $nameController . '.php';

        if (file_exists($pathController)) {
            require_once $pathController;

            $controller = new $nameController;
            $controller->loadModel($targetController);
            $controller->{$targetMethod}($targetArguments);

            return;
        }

        require_once './src/controllers/ErrorController.php';
        require_once './Core/Enums/HttpStatus.php';

        $controller = new ErrorController();
        $controller->renderHttpStatus(HttpStatus::NOT_FOUND);

        return;
    }
}
