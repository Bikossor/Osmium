<?php

namespace Osmium\Controller {
    class ErrorController extends \Osmium\Core\Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function renderHttpStatus(int $statusCode): void
        {
            switch ($statusCode) {
                default:
                case \Osmium\Enum\HttpStatus::NOT_FOUND:
                    header("HTTP/1.1 404 Not Found");
                    $this->view->render('error/404');
                    return;
                case \Osmium\Enum\HttpStatus::INTERNAL_SERVER_ERROR:
                    header("HTTP/1.1 500 Internal Server Error");
                    $this->view->render('error/500');
                    return;
            }
        }
    }
}
