<?php

namespace Osmium\Core {

    use Osmium\Exception\ViewException;

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
                throw new ViewException("View \"$viewName\" doesn't exist!");
            }
        }
    }
}
