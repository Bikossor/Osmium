<?php

namespace Osmium\Controller {
    class LoginController extends \Osmium\Core\Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            //$this->view->data = $this->model->run();
            $this->view->render('login/index');
        }

        public function run()
        {
            $this->model->run();
        }
    }
}
