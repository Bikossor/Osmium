<?php

namespace Osmium\Controller {
    class RestApiController extends \Osmium\Core\Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
        }

        public function Test()
        {
            $this->model->Test();
        }
    }
}
