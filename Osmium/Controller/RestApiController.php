<?php

namespace Osmium\Controller {

    use Osmium\Core\Controller;

    class RestApiController extends Controller
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
