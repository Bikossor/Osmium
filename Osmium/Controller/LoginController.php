<?php

namespace Osmium\Controller {

    use Osmium\Core\Controller;

    class LoginController extends Controller
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
