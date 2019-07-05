<?php
	abstract class Controller {
		public function __construct() {
            require_once './src/exceptions/ModelException.php';

            $this->view = new View();
		}

        public function loadModel(string $name): void {
            $path = './src/models/' . ucfirst($name) . 'Model.php';
            $name = $name . 'Model';

            if(file_exists($path)) {
                require_once $path;
                $this->model = new $name;
            }
            else {
                throw new ModelException("Model \"$name\" doesn't exist!");
            }
        }
	}
?>