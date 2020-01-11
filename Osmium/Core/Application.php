<?php

namespace Osmium\Core {
    class Application
    {
        public function __construct()
        {
        }

        public function run(): void
        {
            $sanitizedUri = filter_input(INPUT_GET, 'uri', FILTER_SANITIZE_URL);
            $trimmedUri = rtrim($sanitizedUri, '/');
            $uriComponent = explode('/', $trimmedUri);

            $targetController = !empty($uriComponent[0]) ? $uriComponent[0] : 'Index';
            $targetMethod = !empty($uriComponent[1]) ? $uriComponent[1] : 'Index';
            $targetArguments = !empty($uriComponent[2]) ? $uriComponent[2] : null;

            $nameController = $targetController . 'Controller';
            $pathController = './Osmium/Controller/' . $nameController . '.php';

            if (file_exists($pathController)) {

                $controllerNamespace = sprintf("\Osmium\Controller\%s", $nameController);
                $controller = new $controllerNamespace;
                $controller->loadModel($targetController);
                $controller->{$targetMethod}($targetArguments);

                return;
            }

            $controller = new \Osmium\Controller\ErrorController();
            $controller->renderHttpStatus(\Osmium\Enum\HttpStatus::NOT_FOUND);

            return;
        }
    }
}
