<?php
    class Application {
    	public function __construct() {
            require './core/libraries/Controller.php';
            //require './core/libraries/View.php';
            require './core/exceptions/ControllerException.php';
        }

        public function run() {
            $path = isset($_GET['uri']) ? explode('/', filter_var(rtrim($_GET['uri'], '/')), FILTER_SANITIZE_URL) : null;

            if(empty($path[0])) {
                require './core/controllers/IndexController.php';
                $controller = new IndexController();
                $controller->loadModel('index');
            }
            else {
                $nameController = $path[0] . 'Controller';
                $pathController = './core/controllers/' . $nameController . '.php';

                if(file_exists($pathController)) {
                    require $pathController;
                    $controller = new $nameController;
                    $controller->loadModel($path[0]);
                }
                else {
                    throw new ControllerException("\"$nameController\" doesn't exist!");
                }
            }

            if(isset($path[1])) {
                if(isset($path[2])) {
                    $controller->{$path[1]}($path[2]);
                }
                else {
                    $controller->{$path[1]}();
                }

            }
            
            $controller->index();
        }
    }
?>
