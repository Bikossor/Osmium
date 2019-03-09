<?php
	abstract class Controller {
		public function __construct() {
            require './core/exceptions/ModelException.php';

            $this->view = new View();
		}

        public function loadModel($name) {
            $path = './core/models/' . ucfirst($name) . 'Model.php';
            $name = $name . 'Model';

            if(file_exists($path)) {
                require $path;
                $this->model = new $name;
            }
            else {
                throw new ModelException("Model \"$name\" doesn't exist!");
            }
        }
	}
?>
