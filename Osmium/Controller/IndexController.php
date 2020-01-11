<?php

namespace Osmium\Controller {
    class IndexController extends \Osmium\Core\Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $this->view->render('index/index');
        }
    }
}
