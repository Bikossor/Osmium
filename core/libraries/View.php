<?php
    class View {
        public function __construct() {
            require './core/exceptions/ViewException.php';
        }

        public function render($viewName) {
            $viewPath = './core/views/' . $viewName . '.phtml';

            if(file_exists($viewPath)) {
                require $viewPath;
            }
            else {
                throw new ViewException("View \"$viewName\" doesn't exist!");
            }
        }
    }
?>
