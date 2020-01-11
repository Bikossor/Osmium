<?php

namespace Osmium\Core {

    use Osmium\Core\View;
    use Osmium\Exception\ModelException;

    abstract class Controller
    {
        public function __construct()
        {
            $this->view = new View();
        }

        public function loadModel(string $name): void
        {
            $path = './Osmium/Model/' . ucfirst($name) . 'Model.php';
            $name = $name . 'Model';

            if (file_exists($path)) {
                $namespace = sprintf("\Osmium\Model\%s", $name);

                $this->model = new $namespace;
            } else {
                throw new ModelException("Model \"$name\" doesn't exist!");
            }
        }
    }
}
