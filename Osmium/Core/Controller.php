<?php

namespace Osmium\Core {
    abstract class Controller
    {
        public function __construct()
        {
            $this->view = new \Osmium\Core\View();
        }

        public function loadModel(string $name): void
        {
            $path = './Osmium/Model/' . ucfirst($name) . 'Model.php';
            $name = $name . 'Model';

            if (file_exists($path)) {
                $namespace = sprintf("\Osmium\Model\%s", $name);

                $this->model = new $namespace;
            } else {
                throw new \Osmium\Exception\ModelException("Model \"$name\" doesn't exist!");
            }
        }
    }
}
