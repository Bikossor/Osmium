<?php
    class View {
        public function __construct() {
            require_once './src/exceptions/ViewException.php';
        }

        public function render(string $viewName): void {
            $viewPath = './src/views/' . $viewName . '.phtml';

            if(file_exists($viewPath)) {
                require_once $viewPath;
            }
            else {
                throw new ViewException("View \"$viewName\" doesn't exist!");
            }
        }
    }
?>
