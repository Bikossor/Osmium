<?php
    require './core/libraries/Controller.php';
    require './core/exceptions/ControllerException.php';

    class Application {
    	public function __construct() { }
        
        public function run() {
            if (RewriteUrl) {
                $path = isset($_GET['uri']) ? explode('/', filter_var(rtrim($_GET['uri'], '/')), FILTER_SANITIZE_URL) : null;
            }
            else {
                $path = isset($_GET['uri']) ? $_GET['uri'] : null;
            }

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
                    header("HTTP/1.1 404 Not Found");
                    include "./core/views/error/404.phtml";
                    return;
                }
            }

            if(isset($path[1])) {
                if(isset($path[2])) {
                    $controller->{$path[1]}($path[2]);
                }
                elseif(method_exists($controller, $path[1])) {
                    $controller->{$path[1]}();
                }
                else {
                    header("HTTP/1.1 404 Not Found");
                    include "./core/views/error/404.phtml";
                    return;
                }
            }
            
            $controller->index();
        }
    }
?>
