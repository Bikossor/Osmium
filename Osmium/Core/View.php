<?php

namespace Osmium\Core {
    class View
    {
        public function __construct()
        {
        }

        public function render(string $viewName): void
        {
            $viewPath = './Osmium/View/' . $viewName . '.phtml';

            if (file_exists($viewPath)) {
                require_once $viewPath;
            } else {
                throw new \Osmium\Exception\ViewException("View \"$viewName\" doesn't exist!");
            }
        }
    }
}
